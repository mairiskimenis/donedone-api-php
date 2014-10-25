<?php

namespace Manavo\DoneDone\Test;

use Manavo\DoneDone\Issue;
use PHPUnit_Framework_TestCase;

class IssueTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        date_default_timezone_set('UTC');
    }

    public function testRequiredParametersIncludedWhenConvertingToArray()
    {
        $issueArray = (new Issue())->toArray();

        $this->assertArrayHasKey('title', $issueArray);
        $this->assertArrayHasKey('priority_level_id', $issueArray);
        $this->assertArrayHasKey('fixer_id', $issueArray);
        $this->assertArrayHasKey('tester_id', $issueArray);

        $this->assertEquals(4, count($issueArray));
    }

    public function testDescriptionIsAddedIfNotEmpty()
    {
        $issue = new Issue();
        $issue->setDescription('desc');

        $this->assertArrayHasKey('description', $issue->toArray());
    }

    public function testUserIdsToCcIsAddedIfNotEmpty()
    {
        $issue = new Issue();
        $issue->setUserIdsToCc('1,2,3');

        $this->assertArrayHasKey('user_ids_to_cc', $issue->toArray());
    }

    public function testDueDateIsAddedIfNotEmpty()
    {
        $issue = new Issue();
        $issue->setDueDate('2014-01-12 12:01:00');

        $this->assertArrayHasKey('due_date', $issue->toArray());
    }

    public function testTagsIsAddedIfNotEmpty()
    {
        $issue = new Issue();
        $issue->setTags('tag1,tag2');

        $this->assertArrayHasKey('tags', $issue->toArray());
    }

    public function testUserIdsToCcIsACommaSeparatedString()
    {
        $issue = new Issue();
        $issue->setUserIdsToCc([1, 2, 3]);

        $this->assertEquals('1,2,3', $issue->toArray()['user_ids_to_cc']);
    }

    public function testTagsIsACommaSeparatedString()
    {
        $issue = new Issue();
        $issue->setTags(['tag1', 'tag2', 'tag3']);

        $this->assertEquals('tag1,tag2,tag3', $issue->toArray()['tags']);
    }

    public function testAttachmentsGetAddedWhenConvertingToArray()
    {
        $issue = new Issue();
        $issue->addAttachment(__FILE__);
        $issue->addAttachment(__FILE__);
        $issue->addAttachment(__FILE__);
        $issue->addAttachment(__FILE__);

        $this->assertEquals(8, count($issue->toArray()));
    }

    public function testUnixTimestampGetsConvertedForDueDate()
    {
        $time = time();

        $issue = new Issue();
        $issue->setDueDate($time);

        $this->assertEquals(date('Y-m-d H:i:s', $time), $issue->toArray()['due_date']);
    }

}