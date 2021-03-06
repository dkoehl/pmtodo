<?php
namespace Pmtodo\Pmtodo\Domain\Repository;


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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * The repository for Todos
 */
class TodoRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    public function setRelationToProject($todoUid, $taskUid){
        $where_clause = 'uid='.$todoUid;
        $fields_value = array(
            'task'   => $taskUid
        );
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_pmtodo_domain_model_todo', $where_clause, $fields_value, $no_quote_fields=FALSE);
    }
    public function resolveTodo($todo){
        $where_clause = 'uid='.$todo->getUid();
        $fields_value = array(
            'status'   => $todo->getStatus()
        );
        if(TRUE === $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_pmtodo_domain_model_todo', $where_clause, $fields_value, $no_quote_fields=FALSE)){
            return true;
        }else{
            return false;
        }
    }


}