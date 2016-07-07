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
 * Test case for class \Pmtodo\Pmtodo\Domain\Model\Task.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>
 */
class TaskTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Pmtodo\Pmtodo\Domain\Model\Task
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Pmtodo\Pmtodo\Domain\Model\Task();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
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
	public function getFilesReturnsInitialValueForFileReference() {
		$this->assertEquals(
			NULL,
			$this->subject->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function setFilesForFileReferenceSetsFiles() {
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setFiles($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'files',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTodosReturnsInitialValueForTodo() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTodos()
		);
	}

	/**
	 * @test
	 */
	public function setTodosForObjectStorageContainingTodoSetsTodos() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();
		$objectStorageHoldingExactlyOneTodos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneTodos->attach($todo);
		$this->subject->setTodos($objectStorageHoldingExactlyOneTodos);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTodos,
			'todos',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTodoToObjectStorageHoldingTodos() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();
		$todosObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$todosObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($todo));
		$this->inject($this->subject, 'todos', $todosObjectStorageMock);

		$this->subject->addTodo($todo);
	}

	/**
	 * @test
	 */
	public function removeTodoFromObjectStorageHoldingTodos() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();
		$todosObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$todosObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($todo));
		$this->inject($this->subject, 'todos', $todosObjectStorageMock);

		$this->subject->removeTodo($todo);

	}
}
