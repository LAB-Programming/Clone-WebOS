<? 
	class fileSystem{
		function __construct(){
			session_start();
			$user_Name = $_SESSION["UserName"];
			if (isset($_GET['Dir'])){$current_Dir = $this->Find_current_dir();}else{$current_Dir = "/var/www/home/".$user_Name."/";}
			$this->get_Current_Contents($current_Dir);
		}
		function Find_current_dir(){
			//echo $_GET['Dir'];
			return $_GET['Dir'];
		}
		function get_Current_Contents($dir){
			$output = array();
			$Dirs_File_Objects = array();

			chdir($dir); exec("ls", $output); //changes the dirctory to the churent directory
			chdir("/var/www/");
			foreach($output as $file){
				$Dirs_File_Objects = array_merge($Dirs_File_Objects, array(new FileClass($file, $dir)));
			}
			if(isset($_GET['del'])){$this->del_file($_GET['del'], $Dirs_File_Objects);}//if some one dels a dir or file
			//if(isset($_GET['new'])){exec('mdir '.$_GET['new']);}
			$this->Render_GUI($Dirs_File_Objects, $dir);
		}
		function Render_GUI($File_Objects, $dir){
			$this->GUI = file_get_contents("/var/www/home/bin/files/FilesGrafics.html");
			$this->GUI = str_replace("<SERVERURL>", "../../../index.php", $this->GUI);
			$this->Dir_statement = '';

			foreach($File_Objects as $File_Object){

				$this->Dir_statement = $this->Dir_statement.'<li><a href="'.$File_Object->Dir_type['location'].'?Dir='.$dir.$File_Object->Dir_name.'">
				<img src="'.$File_Object->Dir_type['icon'].'" class="ui-li-icon ui-corner-none">'.$File_Object->Dir_name.'
				</a><a class="delete" href="files.php?del='.$dir.''.$File_Object->Dir_name.'/" >Delete</a>';
			}
			$this->GUI = str_replace("<FilesHere>", $this->Dir_statement, $this->GUI); 
			echo $this->GUI;
		}
		function del_file($name){
			exec("rm -rf ".$name);
		}
	}
	class FileClass{

		function __construct($dir_name, $current_Dir){
			$this->Dir_name = $dir_name;
			$this->Dir_Extened = $this->getExtention($dir_name);
			$this->Dir_type = $this->getDirOpen($this->Dir_Extened); //holds the title, appurl and icon
			$this->FileURL = $current_Dir.$dir_name;
		}
		function getExtention($name){
			$this->extention = explode(".", $name);
			if (isset($this->extention[1]) == false){
				$this->extention = "NONE";
			}
			else{
				$this->extention = explode('/', $this->extention[1])[0];
			}
			return $this->extention;
		}
		function getDirOpen($extention){
			$this->open_apps = new DOMDocument();
			$this->open_apps->load("home/bin/files/openable.xml");

			//$appsArray = array();
			$this->AppsDocEl = $this->open_apps->documentElement;

			for ($i = 0; $i < $this->AppsDocEl->childNodes->length; $i++){
				if ($extention == $this->AppsDocEl->getElementsByTagName("extention")->item($i)->nodeValue){
					//echo "<script>alert('i work')</script>";
					$Location = $this->AppsDocEl->getElementsByTagName("url")->item($i); //get the location of the first app
					$Location_of_icon = $this->AppsDocEl->getElementsByTagName("icon")->item($i); //get the icon of the first app
					$appArray = array( "location" => $Location->nodeValue, "icon" => $Location_of_icon->nodeValue);
					return $appArray;
					//$appsArray = array_merge($appsArray, array($appArray));
				}

			}

		}
	}
	$start = new fileSystem();

?>
