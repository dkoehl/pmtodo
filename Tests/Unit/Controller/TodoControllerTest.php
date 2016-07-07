<?php
namespace Pmtodo\Pmtodo\Tests\Unit\Controller;
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
 * Test case for class Pmtodo\Pmtodo\Controller\TodoController.
 *
 * @author dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>
 */
class TodoControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Pmtodo\Pmtodo\Controller\TodoController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Pmtodo\\Pmtodo\\Controller\\TodoController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllTodosFromRepositoryAndAssignsThemToView() {

		$allTodos = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$todoRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TodoRepository', array('findAll'), array(), '', FALSE);
		$todoRepository->expects($this->once())->method('findAll')->will($this->returnValue($allTodos));
		$this->inject($this->subject, 'todoRepository', $todoRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('todos', $allTodos);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenTodoToView() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('todo', $todo);

		$this->subject->showAction($todo);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenTodoToView() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newTodo', $todo);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($todo);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenTodoToTodoRepository() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();

		$todoRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TodoRepository', array('add'), array(), '', FALSE);
		$todoRepository->expects($this->once())->method('add')->with($todo);
		$this->inject($this->subject, 'todoRepository', $todoRepository);

		$this->subject->createAction($todo);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenTodoToView() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('todo', $todo);

		$this->subject->editAction($todo);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenTodoInTodoRepository() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();

		$todoRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TodoRepository', array('update'), array(), '', FALSE);
		$todoRepository->expects($this->once())->method('update')->with($todo);
		$this->inject($this->subject, 'todoRepository', $todoRepository);

		$this->subject->updateAction($todo);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenTodoFromTodoRepository() {
		$todo = new \Pmtodo\Pmtodo\Domain\Model\Todo();

		$todoRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TodoRepository', array('remove'), array(), '', FALSE);
		$todoRepository->expects($this->once())->method('remove')->with($todo);
		$this->inject($this->subject, 'todoRepository', $todoRepository);

		$this->subject->deleteAction($todo);
	}
}
