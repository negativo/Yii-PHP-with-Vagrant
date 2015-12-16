<?php
/**
 * @author Bryan Jayson Tan <admin@bryantan.info>.
 * @link http://bryantan.info
 * @date 12/20/12
 * @time 11:26 AM
 */
class TweetMaster extends CWidget
{
    /**
     * @var string
     */
    public $username=null;

    /**
     * @var string
     */
    public $query=null;

    /**
     * available option are 'username' and 'query'
     * @var string
     */
    public $type='username';

    /**
     * options for the tweet master
     * @var array
     */
    public $options=array();

    /**
     * @var string
     */
    public $cssFile=null;

    /**
     * @var string
     */
    public $tag='div';

    /**
     * @var array
     */
    public $tagOptions=array();

    /**
     * if id = null, we will generate a new ID
     * @var null
     */
    public $id=null;

    private $_assetsUrl=null;

    public function init(){
        if (!$this->id){
            $this->id=$this->getId();
        }
        if (!$this->username && !$this->query){
            throw new CException("Username or Query cannot be empty!");
        }else if ($this->username && $this->query){
            throw new CException("Username and Query cannot be initialized at the same time!");
        }

        if ($this->type==='username'){
            $this->options['username']=$this->username;
        }else if ($this->type==='query'){
            $this->options['query']=$this->query;
        }
        $this->tagOptions['id']=$this->id;

        $this->registerClientScript();

    }

    public function run(){
        $options=CJSON::encode($this->options);
        Yii::app()->clientScript->registerScript('tweet'.$this->id,"jQuery('#{$this->id}').tweet({$options})");

        echo CHtml::tag($this->tag,$this->tagOptions,'');
    }

    public function registerClientScript(){
        // publish assets
        $this->_assetsUrl=Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/assets');

        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile($this->_assetsUrl.'/jquery.tweet.js');
        if ($this->cssFile===null){
            Yii::app()->clientScript->registerCssFile($this->_assetsUrl.'/jquery.tweet.css');
        }else{
            Yii::app()->clientScript->registerCssFile($this->cssFile);
        }

    }
}
