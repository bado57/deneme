<?php

class MongoController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->select();
    }

    //select example
    public function select() {
        /*
         * eğer $skip yoksa ama $sort desc yapılacaksa;
         * Not:$sort default halde iken ASC'dir.
         * $skip=0;
         * sorgu  select('shuttleinsert',$limit,$skip,$sort)
         * şeklinde olacaktır
         */
        
        #Sıralamayı belirleyelim. (1 : ASC , -1 : DESC)
        $sort = array('dil' => -1);
        
        //$skipden sonra şu kadar getir anlamındadır
        $skip=3;
        
        //$limit kadar getir anlamında kullanılır
        $limit=4;

        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->select('shuttleinsert',$limit,$skip,$sort);
        #kayıtlı verileri listeleyelim. 
        foreach ($result as $sonuc) {
            printf('Dil : %s - Miktar : %s <br>', $sonuc['dil'], $sonuc['makalesayisi']);
        }
    }

    //insert example
    public function insert() {
        $array = array(
            'dil' => 'Java',
            'makalesayisi' => 12);

        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->insert('shuttleinsert', $array);
        
        echo $result;
    }

    //delete example
    public function delete() {
        $array = array(
            'dil' => 'J'
        );

        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->delete('shuttleinsert', $array);
        
        echo $result;
    }

    //update example
    public function update() {
        //Güncellenecek kaydın koşulu
        $oldarray = array(
            'dil' => 'JAVAA'
        );
        $newarray = array(
            'dil' => 'J'
        );

        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->update('shuttleinsert', $oldaray, $newarray);
        
        echo $result;
    }

    //deleteCollection example
    public function deleteCollection() {
        $collectionName = '';
        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->deleteCollection($collectionName);
        
        echo $result;
    }

    //deleteCollection example
    public function deleteDatabase() {
        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->deleteDatabase();
        
        
        
        echo $result;
    }

    //CollecionCount example
    public function count() {
        $model = $this->load->model("MongoDeneme_Model");
        $result = $model->count('shuttleinsert');

        echo $result;
    }

}

?>                                                                                                                                                                                                                                                                                                                                                                    