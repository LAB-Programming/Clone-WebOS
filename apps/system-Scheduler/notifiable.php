<?php
	interface Notifiable{
		public function getRank();
		public function setRank($newRank);
		public function getBody();
		public function setBody($textBody);
	}
?>