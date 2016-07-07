<?php
namespace Pmtodo\Pmtodo\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>, pm-newmedia.com
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Project
 */
class Project extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * startdate
	 *
	 * @var string
	 */
	protected $startdate = NULL;

	/**
	 * enddate
	 *
	 * @var string
	 */
	protected $enddate = NULL;



    /**
     * username
     *
     * @var string
     */
    protected $username = NULL;

    /**
     * Returns the username
     *
     * @return string $username
     */
    public function getUsername() {
        return $this->username;
    }
    /**
     * Sets the username
     *
     * @param string $username
     * @return void
     */
    public function setUsername($username) {
        $this->username = $username;
    }



	/**
	 * tasks
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmtodo\Pmtodo\Domain\Model\Task>
	 * @cascade remove
	 */
	protected $tasks = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->tasks = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the startdate
	 *
	 * @return string $startdate
	 */
	public function getStartdate() {
		return $this->startdate;
	}

	/**
	 * Sets the startdate
	 *
	 * @param string $startdate
	 * @return void
	 */
	public function setStartdate( $startdate) {
		$this->startdate = strtotime($startdate);
	}

	/**
	 * Returns the enddate
	 *
	 * @return string $enddate
	 */
	public function getEnddate() {
		return $this->enddate;
	}

	/**
	 * Sets the enddate
	 *
	 * @param string $enddate
	 * @return void
	 */
	public function setEnddate( $enddate) {
		$this->enddate = strtotime($enddate);
	}

	/**
	 * Adds a Task
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $task
	 * @return void
	 */
	public function addTask(\Pmtodo\Pmtodo\Domain\Model\Task $task) {
		$this->tasks->attach($task);
	}

	/**
	 * Removes a Task
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $taskToRemove The Task to be removed
	 * @return void
	 */
	public function removeTask(\Pmtodo\Pmtodo\Domain\Model\Task $taskToRemove) {
		$this->tasks->detach($taskToRemove);
	}

	/**
	 * Returns the tasks
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmtodo\Pmtodo\Domain\Model\Task> $tasks
	 */
	public function getTasks() {
		return $this->tasks;
	}

	/**
	 * Sets the tasks
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pmtodo\Pmtodo\Domain\Model\Task> $tasks
	 * @return void
	 */
	public function setTasks(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tasks) {
		$this->tasks = $tasks;
	}

}