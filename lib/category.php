<?php
//Экземпляр класса может быть вызван лишь один раз.
//Реализован патерн Singleton
  class Lib_Category extends Lib_DateBase
  {
	public $categories;
	protected static $instance; //(экземпляр объекта) Защищаем от создания через new Singleton
	
	//получаем таблицу категорий из БД, записываем в массив, для дальнейшей работы
	private function __construct() {
		$result = parent::query("SELECT * FROM  `category` ORDER BY sort ");
		if(parent::num_rows($result))
		{
			while ($row = parent::fetch_assoc($result))
			{		
					$this->categories[]=$row; 
			}
			
			sort($this->categories);
	
		}
		

	}
	

	public static function getInstance() {//Возвращает единственный экземпляр класса
		if (!is_object(self::$instance)) self::$instance = new self;
		return self::$instance;
    }
	 
	//создает новую категорию.
	public function  addCategory($array)
	{		

		$array['url']=translitIt($array['title']);
		if(strlen($array['url'])>60)$array['url']=	substr($array['url'], 0, 60);
		//для чистоты работы, тут лучше проверить на уже существующие url,
			if(parent::build_query("INSERT INTO category SET ",$array)){
			    $id = parent::insert_id();
				return $id;
			}
		
		return	false;

	}
		//редактирует  категорию.
	public function  editCategory($id,$array)
	{		
	$array['url']=translitIt($array['title']);
		if(strlen($array['url'])>60)$array['url']=	substr($array['url'], 0, 60);
		if(parent::query("UPDATE category SET ".parent::build_part_query($array)." WHERE id = %d",$id)){			   
				return true;
			}
		return	false;
	}
	
		//создает новую категорию.
	public function  delCategory($id)
	{		
		if(parent::query("DELETE FROM category WHERE id = %d",$id)){
		return true;
		}
		return	false;
		
	}
	
	
	//возвращает древовидный список категорий, пригодный для использования в меню.   
	public function  getCategoryList_UL($parent=0)
	{	
	 
	 foreach($this->categories as $category){
	 		
		 if($category["parent"]==$parent){
			$print.='
			<li><a href="/'.$category['url'].'">'.$category['title'].'</a>';
			
			foreach($this->categories as $sub_category){ 
		
				 if($sub_category["parent"]==$category['id']){
					$flag=true;
					break;
				 }
			}
			 
			if($flag){
				$print.="<ul>";
			
				$print.= $this->getCategoryList_UL($category['id']);
				$print.="</ul>";
				$print.='
				</li>';
			}else
			$print.='</li>';	
		 }
		
	 }
	 	
	 return  $print;		 
	}
	
	//возвращает список только id всех вложеных категорий.
	public function  getCategoryList($parent=0)
	{		
		foreach($this->categories as $category){	 		
		 if($category["parent"]==$parent){		
					$this->list_category_id[]=$category['id'];
					$this->getCategoryList($category["id"]);						
			}	
		}

	 return  $this->list_category_id;	
	}
	
		//возвращает список только id всех вложеных категорий.
	public function  getCategoryTitleList()
	{		
		foreach($this->categories as $category){	 		
		$titleList[$category["id"]]=$category["title"];
		}

	 return  $titleList;	
	}
	
	//возвращает иерархический массив категорий
	public function  getHierarchyCategory($parent=0)
	{
	$cat_array=array();
		 foreach($this->categories as $category){	 		
			 if($category["parent"]==$parent){	
						$child=$this->getHierarchyCategory($category["id"]);
						
						if(!empty($child)){						
							$array=$category;
							$array["child"]=$child;	
							}
						else
							$array=$category;
						
						$cat_array[]=$array;
										
				}	
			}

		 return  $cat_array;		
	}
	
	
	public function  getTitleCategory($array_categories)
	{
		global $lvl;
			foreach($array_categories as $category){
			
				
				$option.="<option value=".$category["id"].">";
				$option.= str_repeat("-", $lvl);
				$option.= $category["title"];
				$option.="</option>";
		
				if(isset($category["child"])){
					$lvl++;
					$option.= $this->getTitleCategory($category["child"]);
					$lvl--;
				}
			}
		return $option;	
	}
	
	
	public function  getCategoryTree($parent=0)
	{	
	
	 foreach($this->categories as $category){
	 		
		 if($category["parent"]==$parent){
			$print.='
			<li><a href="#" rel="CategoryTree" id="'.$category['id'].'" parent_id="'.$category["parent"].'">'.$category['title'].'</a>';
			
			foreach($this->categories as $sub_category){ 
				 if($sub_category["parent"]==$category['id']){
					$flag=true;
					break;
				 }
			}
			 
			if($flag){
				$print.="<ul>";
				$print.= $this->getCategoryTree($category['id']);
				$print.="</ul>";
				$print.='
				</li>';
			}else
			$print.='</li>';	
		 }
		
	 }
	 	
	 return  $print;		 
	}
 }
 
 
/*
  Автор: Авдеев Марк.
  e-mail: mark-avdeev@mail.ru
  blog: lifeexample.ru
*/