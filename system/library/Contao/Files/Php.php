<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Library
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Contao;

use \Files;


/**
 * Class Files_Php
 *
 * Provide methods to modify files and folders.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Library
 */
class Files_Php extends Files
{

	/**
	 * Create a directory
	 * @param string
	 * @return boolean
	 */
	public function mkdir($strDirectory)
	{
		$this->validate($strDirectory);
		return @mkdir(TL_ROOT . '/' . $strDirectory);
	}


	/**
	 * Remove a directory
	 * @param string
	 * @return boolean
	 */
	public function rmdir($strDirectory)
	{
		$this->validate($strDirectory);
		return @rmdir(TL_ROOT. '/' . $strDirectory);
	}


	/**
	 * Open a file and return the handle
	 * @param string
	 * @param string
	 * @return resource
	 */
	public function fopen($strFile, $strMode)
	{
		$this->validate($strFile);
		return @fopen(TL_ROOT . '/' . $strFile, $strMode);
	}


	/**
	 * Write content to a file
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function fputs($resFile, $strContent)
	{
		return @fputs($resFile, $strContent);
	}


	/**
	 * Close a file
	 * @param resource
	 * @return boolean
	 */
	public function fclose($resFile)
	{
		return @fclose($resFile);
	}


	/**
	 * Rename a file or folder
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function rename($strOldName, $strNewName)
	{
		// Source file == target file
		if ($strOldName == $strNewName)
		{
			return true;
		}

		$this->validate($strOldName, $strNewName);

		// Windows fix: delete the target file
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && file_exists(TL_ROOT . '/' . $strNewName))
		{
			$this->delete($strNewName);
		}

		// Unix fix: rename case sensitively
		if (strcasecmp($strOldName, $strNewName) === 0 && strcmp($strOldName, $strNewName) !== 0)
		{
			@rename(TL_ROOT . '/' . $strOldName, TL_ROOT . '/' . $strOldName . '__');
			$strOldName .= '__';
		}

		return @rename(TL_ROOT . '/' . $strOldName, TL_ROOT . '/' . $strNewName);
	}


	/**
	 * Copy a file or folder
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function copy($strSource, $strDestination)
	{
		$this->validate($strSource, $strDestination);
		return @copy(TL_ROOT . '/' . $strSource, TL_ROOT . '/' . $strDestination);
	}


	/**
	 * Delete a file
	 * @param string
	 * @return boolean
	 */
	public function delete($strFile)
	{
		$this->validate($strFile);
		return @unlink(TL_ROOT . '/' . $strFile);
	}


	/**
	 * Change file mode
	 * @param string
	 * @param mixed
	 * @return boolean
	 */
	public function chmod($strFile, $varMode)
	{
		$this->validate($strFile);
		return @chmod(TL_ROOT . '/' . $strFile, $varMode);
	}


	/**
	 * Check whether a file is writeable
	 * @param string
	 * @return boolean
	 */
	public function is_writeable($strFile)
	{
		$this->validate($strFile);
		return @is_writeable(TL_ROOT . '/' . $strFile);
	}


	/**
	 * Move an uploaded file to another folder
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function move_uploaded_file($strSource, $strDestination)
	{
		$this->validate($strSource, $strDestination);
		return @move_uploaded_file($strSource, TL_ROOT . '/' . $strDestination);
	}
}