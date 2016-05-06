<?php

namespace app\models;
use yii\db\Query;
use Yii;

/**
 * This is the model class for table "foro".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property integer $creado_at
 * @property integer $actualizado_at
 * @property integer $user_id
 * @property integer $post_count
 */
class Foro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $nombres_apellidos;
    public $total_comentario;
    public $falta_valorar;
    public $valorado;
    public static function tableName()
    {
        return 'foro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creado_at', 'actualizado_at', 'user_id', 'post_count','id'], 'integer'],
            [['titulo'], 'string', 'max' => 250],
            [['descripcion'], 'string', 'max' => 1500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'creado_at' => 'Creado At',
            'actualizado_at' => 'Actualizado At',
            'user_id' => 'User ID',
            'post_count' => 'Post Count',
        ];
    }
    
    
    
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
    
    public function getAsunto()
    {
        return $this->hasOne(Asunto::className(), ['id' => 'asunto_id']);
    }
    
    public function getPosts($id)
    {
        $query = new Query;
        $query->select('p.id,  p.contenido, p.creado_at, p.user_id, u.username, u.avatar , es.nombres, es.apellido_paterno')
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->join('INNER JOIN','{{%estudiante}} as es', 'es.id=u.estudiante_id')
            ->where('p.foro_id=:id', [':id' => $this->id]);
            
        
        
        if($id==2){
            $result = Yii::$app->tools->Pagination($query,5);
        }elseif($id>=3 && $id<=35) {
            $result = Yii::$app->tools->Pagination($query,3);
        } else{
            $result = Yii::$app->tools->Pagination($query,5);
        }
        return ['posts' => $result['result'], 'pages' => $result['pages']];
    }
    
    
    public function getPostsAdmin($id)
    {
        $query = new Query;
        $query->select('p.id,  p.contenido, p.creado_at, p.user_id, u.username, u.avatar , es.nombres, es.apellido_paterno , p.valoracion')
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->join('INNER JOIN','{{%estudiante}} as es', 'es.id=u.estudiante_id')
            ->where('p.foro_id=:id', [':id' => $this->id]);
            
        
        
        $result = Yii::$app->tools->Pagination($query,8);
        
        return ['posts' => $result['result'], 'pages' => $result['pages']];
    }
}
