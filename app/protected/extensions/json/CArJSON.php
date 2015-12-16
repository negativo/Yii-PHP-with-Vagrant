<?php
/**
 * JSON extension class.
 *
 *
 * @package    Extension
 * @author     Emanuele Ricci
 * @copyright  (c) 2010 Emanuele Ricci
 * @license    http://www.designfuture.it
 */
class CArJSON {
	
	private $owner;
	private $relations;
	private $relations_allowed;
	private $attributes;
	private $jsonString;
	
	/*
	 * array ( 
	 * 		'root'=> array of attributes,
	 * 		'relation_name' => array of attributes,
	 * )
	 * 
	 * if a relation_name is not setted or defined we will take all attributes
	 * 
	 */
	
	public function toJSON( $model, $relations, $attributesAllowed=array() ){
		$this->owner = $model;
		$this->relations_allowed = $relations;
		$this->attributes = $attributesAllowed;
		$this->jsonString = '';
		if ( !is_array($this->owner) ) {
			$this->owner = array();
			$this->owner[] = $model;
		}
		return $this->getJSON();
	}
	
	private function getJSON() {
		foreach ( $this->owner as $o ) {
			$result = $this->getJSONModel( $o );
			if ( !$result ) return false; 
			else $this->jsonString .= $result . ',';
		}
		$this->jsonString = substr($this->jsonString, 0, -1);
		$this->jsonString = '['.$this->jsonString.']';
		return $this->jsonString;
	}
	
	private function getJSONModel( $obj ) {
		if (is_subclass_of($obj,'CActiveRecord')){
			$attributes = $obj->getAttributes( $this->attributes['root'] );
			$this->relations = $this->getRelated( $obj );
			$jsonDataSource = array('attributes'=>$attributes,'relations'=>$this->relations);
			return CJSON::encode($jsonDataSource);
		}
		return false;
	}
	
	private function getRelated( $m )
	{	
		$related = array();
		$obj = null;
		$md=$m->getMetaData();
		foreach($md->relations as $name=>$relation){
			if ( !in_array($name, $this->relations_allowed ) )
				continue;
			$obj = $m->getRelated($name);
			$attrToTake = empty($this->attributes[$name]) ? NULL : $this->attributes[$name];
			$related[$name] = $obj instanceof CActiveRecord ? $obj->getAttributes($attrToTake) : $obj;
		}
	    return $related;
	}
}