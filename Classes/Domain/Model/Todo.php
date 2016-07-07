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
 * Todo
 */
class Todo extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

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
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * files
     *
	 *
	 * @var string $files
	 */
	protected $files = NULL;

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
     * status
     *
     * @var string
     */
    protected $status = NULL;

    /**
     * Returns the status
     *
     * @return string $status
     */
    public function getStatus() {
        return $this->status;
    }
    /**
     * Sets the status
     *
     * @param string $status
     * @return void
     */
    public function setStatus($status) {
        $this->status = $status;
    }




    /**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
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
     * Returns the files
     *
     * @return string $files
     */
    public function getFiles() {
        if(!empty($this->files)){
            $filesArray = explode(',', $this->files);
            if(is_array($filesArray)){
                foreach($filesArray as $item){
                    $file = pathinfo( \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('uploads/tx_pmtodo/'.$item));

                    if(is_file($file['dirname'] . '/' . $file['basename'])){
                        $bytes = filesize($file['dirname'] . '/' . $file['basename']);

                        if ($bytes >= 1073741824)
                        {
                            $bytes = number_format($bytes / 1073741824, 2) . 'GB';
                        }
                        elseif ($bytes >= 1048576)
                        {
                            $bytes = number_format($bytes / 1048576, 2) . 'MB';
                        }
                        elseif ($bytes >= 1024)
                        {
                            $bytes = number_format($bytes / 1024, 2) . 'KB';
                        }
                        elseif ($bytes > 1)
                        {
                            $bytes = $bytes . 'bytes';
                        }
                        elseif ($bytes == 1)
                        {
                            $bytes = $bytes . 'byte';
                        }
                        else
                        {
                            $bytes = '0 bytes';
                        }
                        $returnFile[] = array_merge($file, array('filesize'=> $bytes));
                    }

                }
            }
            return $returnFile;
        }

    }

    /**
     * Sets the files
     *
     * @param string $files
     * @return void
     */
    public function setFiles( $files) {
        if(is_array($files)){
            $fileString = '';
            foreach($files as $item){
                $fileString .= $item . ',';
            }
            $this->files = substr($fileString,0,-1);
        }else{
            $this->files = $files;
        }
    }

}