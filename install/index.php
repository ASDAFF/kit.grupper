<?
global $MESS;
IncludeModuleLangFile(__FILE__);

Class kit_grupper extends CModule
{
    var $MODULE_ID = "kit.grupper";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function kit_grupper()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");
	
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        } else {
            $this->MODULE_VERSION = "1.0.0";
            $this->MODULE_VERSION_DATE = "2013.01.01";
        }

		$this->MODULE_NAME = GetMessage("INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("INSTALL_COPMPANY_NAME");
        $this->PARTNER_URI  = "https://asdaff.github.io/";
	}

	// Install functions
	function InstallDB()
	{
		global $DB, $DBType, $APPLICATION;
		RegisterModule("kit.grupper");
		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/kit.grupper/install/db/".$DBType."/install.sql");
		return TRUE;
	}

	function InstallEvents()
	{
		RegisterModuleDependences("main", "OnBuildGlobalMenu", "kit.grupper", "CRSGrupper", "HandlerOnBuildGlobalMenu", 100000);
		RegisterModuleDependences("main", "OnAdminContextMenuShow", "kit.grupper", "CRSGrupper", "HandlerOnAdminContextMenuShow", 100000);
		return TRUE;
	}

	function InstallOptions()
	{
		return TRUE;
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/kit.grupper/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/kit.grupper/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);
		return TRUE;
	}

	function InstallPublic()
	{
		return TRUE;
	}

	// UnInstal functions
	function UnInstallDB()
	{
		global $DB, $DBType, $APPLICATION;
		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/kit.grupper/install/db/".$DBType."/uninstall.sql");
		UnRegisterModule("kit.grupper");
		return TRUE;
	}

	function UnInstallEvents()
	{
		UnRegisterModuleDependences("main", "OnBuildGlobalMenu", "kit.grupper", "CRSGrupper", "HandlerOnBuildGlobalMenu");
		UnRegisterModuleDependences("main", "OnAdminContextMenuShow", "kit.grupper", "CRSGrupper", "HandlerOnAdminContextMenuShow");
		return TRUE;
	}

	function UnInstallOptions()
	{
		return TRUE;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/admin/kit_grupper.php");
		DeleteDirFilesEx("/bitrix/admin/kit_grupper_edit.php");
		DeleteDirFilesEx("/bitrix/admin/kit_grupper_popup.php");
		return TRUE;
	}

	function UnInstallPublic()
	{
		return TRUE;
	}

    function DoInstall()
    {
		global $APPLICATION, $step;
		$keyGoodDB = $this->InstallDB();
		$keyGoodEvents = $this->InstallEvents();
		$keyGoodOptions = $this->InstallOptions();
		$keyGoodFiles = $this->InstallFiles();
		$keyGoodPublic = $this->InstallPublic();
		$APPLICATION->IncludeAdminFile(GetMessage("SPER_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/kit.grupper/install/install.php");
    }

    function DoUninstall()
    {
		global $APPLICATION, $step;
		$keyGoodFiles = $this->UnInstallFiles();
		$keyGoodEvents = $this->UnInstallEvents();
		$keyGoodOptions = $this->UnInstallOptions();
		$keyGoodDB = $this->UnInstallDB();
		$keyGoodPublic = $this->UnInstallPublic();
		$APPLICATION->IncludeAdminFile(GetMessage("SPER_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/kit.grupper/install/uninstall.php");
    }
}
?>