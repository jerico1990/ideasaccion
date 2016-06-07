<?php

namespace app\models;
use yii\db\Query;
use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "proyecto".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $resumen
 * @property string $justificacion
 * @property string $objetivo_general
 * @property string $beneficiario_directo_1
 * @property string $beneficiario_directo_2
 * @property string $beneficiario_directo_3
 * @property string $beneficiario_indirecto_1
 * @property string $beneficiario_indirecto_2
 * @property string $beneficiario_indirecto_3
 * @property integer $user_id
 *
 * @property ObjetivoEspecifico[] $objetivoEspecificos
 * @property Usuario $user
 */
class Proyecto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $archivo;
    public $valorados;
    public $faltan_valorar;
    
    public $objetivo_especifico_1;
    public $objetivo_especifico_1_id;
    public $objetivo_especifico_2;
    public $objetivo_especifico_2_id;
    public $objetivo_especifico_3;
    public $objetivo_especifico_3_id;
    public $actividades_1;
    public $actividades_2;
    public $actividades_3;
    public $objetivo_especifico_id;
    public $actividad_id;
    public $actividades_ids_1;
    public $actividades_ids_2;
    public $actividades_ids_3;
    public $p1;
    public $p2;
    public $p3;
    public $evaluacion;
    public $forum_url;
    
    /*plan presupuestal*/
    public $planes_presupuestales_objetivos;
    public $planes_presupuestales_actividades;
    public $planes_presupuestales_recursos;
    public $planes_presupuestales_comos_conseguirlos;
    public $planes_presupuestales_precios_unitarios;
    public $planes_presupuestales_cantidades;
    public $planes_presupuestales_subtotales;
    public $planes_presupuestal_ids;
    public $planes_presupuestales_recursos_descripciones;
    public $planes_presupuestales_unidades;
    public $planes_presupuestales_dirigidos;
    
    
    /*cronograma*/
    public $cronogramas_objetivos;
    public $cronogramas_actividades;
    public $cronogramas_tareas;
    public $cronogramas_responsables;
    public $cronogramas_fechas_inicios;
    public $cronogramas_fechas_fines;
    public $cronogramas_ids;
    
    /*Resultados*/
    public $resultados_ids;
    public $resultados_esperados;
    
    /*dd*/
    public $foro_id;
    public $ruta;
    public static function tableName()
    {
        return 'proyecto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[  'cronogramas_objetivos','cronogramas_actividades','cronogramas_responsables','cronogramas_fechas_inicios',
                'cronogramas_fechas_fines','cronogramas_ids','resultados_ids','resultados_esperados',
                'planes_presupuestales_objetivos','planes_presupuestales_actividades','planes_presupuestales_recursos',
                'planes_presupuestales_comos_conseguirlos','planes_presupuestales_precios_unitarios',
                'planes_presupuestales_cantidades','planes_presupuestales_subtotales','planes_presupuestal_ids',
                'planes_presupuestales_dirigidos','planes_presupuestales_unidades','planes_presupuestales_recursos_descripciones'],'safe'],
            [['id','actividades_1','actividades_2','actividades_3','actividades_ids_1','actividades_ids_2','actividades_ids_3','cronogramas_tareas'],'safe'],
            [['user_id','asunto_id','objetivo_especifico_1_id','objetivo_especifico_2_id','objetivo_especifico_3_id','equipo_id','region_id'], 'integer'],
            [['titulo','proyecto_archivo'], 'string', 'max' => 200],
            [['ruta'], 'string', 'max' => 250],
            
            [['resumen','beneficiario','evaluacion'], 'string', 'max' => 25000],
            [['p1','p2','p3'], 'string', 'max' => 5000],
            [['forum_url','objetivo_general','objetivo_especifico_1','objetivo_especifico_2','objetivo_especifico_3'], 'string', 'max' => 300],
            [['archivo'], 'file'],
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
            'resumen' => 'Resumen',
            'justificacion' => 'Justificacion',
            'objetivo_general' => 'Objetivo General',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivoEspecificos()
    {
        return $this->hasMany(ObjetivoEspecifico::className(), ['proyecto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
    
    public function getEquipo()
    {
        return $this->hasOne(Equipo::className(), ['id' => 'equipo_id']);
    }
    
    public function beforeSave($insert)
    {
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $integrante=Integrante::find()
                    ->select('integrante.equipo_id,ubigeo.department_id')
                    ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                    ->innerJoin('institucion','institucion.id=estudiante.institucion_id')
                    ->innerJoin('ubigeo','ubigeo.district_id=institucion.ubigeo_id')
                    ->where('integrante.estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $equipo=Equipo::findOne($integrante->equipo_id);
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->region_id=$integrante->department_id;
                $this->asunto_id=$equipo->asunto_id;
                $this->user_id = \Yii::$app->user->id;
                $this->equipo_id= $integrante->equipo_id;
                $this->formato_proyecto=0;
            }
            return true;
        } else {
            return false;
        }
    }
    
    
    
    public function getProyectos($sort,$region)
    {
        
        //total_equipos province   total_alumnos  district  total_equipos_nofinalizado latitude  total_alumnos_nofinalizado longitud
        $query = new Query;
        if($region)
        {
            $query
            ->select(['
                        p.id,
                        p.asunto_id,
                        p.titulo, 
                        COUNT( i.estudiante_id ) AS total_integrantes,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=p.asunto_id and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                        IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = p.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                        IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = p.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                        IF(trim(p.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                        IF(e.etapa=1,1,0) as proyecto_finalizado
                      '])
            ->from('proyecto p')
            ->innerJoin('equipo e','e.id = p.equipo_id')
            ->innerJoin('integrante i','i.equipo_id = e.id')
            ->innerJoin('estudiante es','es.id=i.estudiante_id')
            ->innerJoin('institucion ins','ins.id=es.institucion_id')
            ->innerJoin('ubigeo u','u.district_id=ins.ubigeo_id')
            ->where('u.department_id=:department_id',[':department_id'=>$region])
            ->groupBy('p.id,p.titulo')
            ->orderBy($sort);
        }
        else
        {
            $query
            ->select(['
                        p.id,
                        p.asunto_id,
                        p.titulo, 
                        COUNT( i.estudiante_id ) AS total_integrantes,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=p.asunto_id and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                        IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = p.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                        IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = p.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                        IF(trim(p.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                        IF(e.etapa=1,1,0) as proyecto_finalizado
                      '])
            ->from('proyecto p')
            ->innerJoin('equipo e','e.id = p.equipo_id')
            ->innerJoin('integrante i','i.equipo_id = e.id')
            ->innerJoin('estudiante es','es.id=i.estudiante_id')
            ->innerJoin('institucion ins','ins.id=es.institucion_id')
            ->innerJoin('ubigeo u','u.district_id=ins.ubigeo_id')
            ->groupBy('p.id,p.titulo')
            ->orderBy($sort);
        }
        
            
        $result = Yii::$app->tools->Pagination($query,10);
        
        return ['proyectos' => $result['result'], 'pages' => $result['pages']];
    }
}
