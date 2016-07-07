<?php

namespace Pmtodo\Pmtodo\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>, pm-newmedia.com
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Pmtodo\Pmtodo\Domain\Model\Project.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>
 */
class ProjectTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Pmtodo\Pmtodo\Domain\Model\Project
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Pmtodo\Pmtodo\Domain\Model\Project();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName() {
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() {
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStartdateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getStartdate()
		);
	}

	/**
	 * @test
	 */
	public function setStartdateForDateTimeSetsStartdate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setStartdate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'startdate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEnddateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getEnddate()
		);
	}

	/**
	 * @test
	 */
	public function setEnddateForDateTimeSetsEnddate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setEnddate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'enddate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTasksReturnsInitialValueForTask() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTasks()
		);
	}

	/**
	 * @test
	 */
	public function setTasksForObjectStorageContainingTaskSetsTasks() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();
		$objectStorageHoldingExactlyOneTasks = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneTasks->attach($task);
		$this->subject->setTasks($objectStorageHoldingExactlyOneTasks);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTasks,
			'tasks',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTaskToObjectStorageHoldingTasks() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();
		$tasksObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$tasksObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($task));
		$this->inject($this->subject, 'tasks', $tasksObjectStorageMock);

		$this->subject->addTask($task);
	}

	/**
	 * @test
	 */
	public function removeTaskFromObjectStorageHoldingTasks() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();
		$tasksObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$tasksObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($task));
		$this->inject($this->subject, 'tasks', $tasksObjectStorageMock);

		$this->subject->removeTask($task);

	}
}
