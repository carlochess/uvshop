<?php
	class ControladorFactory{
		public static function factory($nombre){
			if (file_exists('aplicacion/controlador/' . $nombre . '.php')) {
				require 'aplicacion/controlador/' . $nombre . '.php';
				return new $nombre();
			} else {
				return NULL;
			}
		}
	}