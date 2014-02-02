<?php
function dateSqlBr($data,$tipo) {
	if (($data) && ($data <> '0000-00-00') && ($data <> '00/00/0000') && ($tipo)) {
		switch($tipo) {
			case 'sql->br':
				$res= date('d/m/Y',strtotime($data));
			break;
			case 'br->sql':
				$res=  implode('-',array_reverse(explode('/',$data)));
			break;
		}
		return $res;
	} else
		return null;
}
?>