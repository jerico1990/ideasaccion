<?php

namespace app\controllers;

use Yii;
use app\models\Integrante;
use app\models\Registrar;
use app\models\Invitacion;
use app\models\Institucion;
use app\models\Estudiante;
use app\models\EstudianteSearch;
use app\models\Equipo;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;

use yii\web\UploadedFile;
/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class InscripcionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Participante models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='estandar';
        
        $equipo=new Equipo;
        //$equipo->foto='no_disponible.png';
        $institucion=Institucion::find()
                    ->select('institucion.id,estudiante.id as estudiante_id,ubigeo.department_id')
                    ->innerJoin('estudiante','estudiante.institucion_id=institucion.id')
                    ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                    ->innerJoin('ubigeo','ubigeo.district_id=institucion.ubigeo_id')
                    ->where('usuario.id='.\Yii::$app->user->id.'')
                    ->one();
        
        $estudiantes=Estudiante::find()
                    ->where('estudiante.grado!=6 and estudiante.institucion_id=:institucion_id and estudiante.id
                            not in (select integrante.estudiante_id from integrante
                                    inner join estudiante on estudiante.id=integrante.estudiante_id
                                    where estudiante.grado!=6)
                            and estudiante.id!=:id
                            ',[':institucion_id'=>$institucion->id,':id'=>$institucion->estudiante_id])
                    ->orderBy('grado asc')->all();
        
        
        $docentes=Estudiante::find()
                    ->where('estudiante.grado=6 and estudiante.institucion_id=:institucion_id and estudiante.id
                            not in (select integrante.estudiante_id from integrante
                                    inner join estudiante on estudiante.id=integrante.estudiante_id
                                    where estudiante.grado=6)
                            and estudiante.id!=:id
                            ',[':institucion_id'=>$institucion->id,':id'=>$institucion->estudiante_id])
                    ->orderBy('grado asc')->all();
                    
                    
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$institucion->estudiante_id])->one();
        if($integrante)
        {
            return $this->redirect(['panel/index']);
        }
        
        $invitacionContador=1;
        $invitacionContadorDocente=0;
        if ($equipo->load(Yii::$app->request->post()) && $equipo->validate() ) {
            $equipo->foto_img = UploadedFile::getInstance($equipo, 'foto_img');
            
            $bandera=true;
            $nombres="";
            $equipo->fecha_registro=date("Y-m-d H:i:s");
            $equipo->estado=0;
            $equipo->save();
            if($equipo->foto_img)
            {
                $equipo->foto=$equipo->id. '.' . $equipo->foto_img->extension;
            }
            else
            {
                $equipo->foto="";//cambio img
            }
            $equipo->update();
            $lider=new Integrante;
            $lider->equipo_id=$equipo->id;
            $lider->estudiante_id=$institucion->estudiante_id;
            $lider->rol=1;//lider
            $lider->estado=1;
            $lider->save();
            
            Invitacion::updateAll(['estado' => 0], 'estado = 1 and estudiante_invitado_id=:estudiante_invitado_id',
                              [':estudiante_invitado_id'=>$institucion->estudiante_id]);
            
            if(isset($equipo->invitaciones))
            {
                $countInvitaciones=count($equipo->invitaciones);
                for($i=0;$i<$countInvitaciones;$i++)
                {
                    $invitacion=new Invitacion;
                    $integrante=Integrante::find()
                    ->select('estudiante.nombres_apellidos')
                    ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                    ->where('integrante.estudiante_id=:estudiante_id',[':estudiante_id'=>$equipo->invitaciones[$i]])->one();
                    if(!$integrante)
                    {
                        $invitacion->estudiante_id=$institucion->estudiante_id;
                        $invitacion->equipo_id=$equipo->id;
                        $invitacion->estudiante_invitado_id=$equipo->invitaciones[$i];
                        $invitacion->estado=1;
                        $invitacion->fecha_invitacion=date("Y-m-d H:i:s");
                        $invitacion->save();
                    }
                }
            }
            
            if(isset($equipo->invitaciones_docente))
            {
                $countInvitaciones=count($equipo->invitaciones_docente);
                for($i=0;$i<$countInvitaciones;$i++)
                {
                    $invitacion=new Invitacion;
                    $integrante=Integrante::find()
                    ->select('estudiante.nombres_apellidos')
                    ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                    ->where('integrante.estudiante_id=:estudiante_id',[':estudiante_id'=>$equipo->invitaciones[$i]])->one();
                    if(!$integrante)
                    {
                        $invitacion->estudiante_id=$institucion->estudiante_id;
                        $invitacion->equipo_id=$equipo->id;
                        $invitacion->estudiante_invitado_id=$equipo->invitaciones_docente[$i];
                        $invitacion->estado=1;
                        $invitacion->fecha_invitacion=date("Y-m-d H:i:s");
                        $invitacion->save();
                    }
                }
            }
            
            if($equipo->foto_img)
            {
                $equipo->foto_img->saveAs('foto_equipo/' . $equipo->id . '.' . $equipo->foto_img->extension);
            }
            Yii::$app->session->setFlash('equipocreado');
            return $this->redirect(['panel/index']);
           
        }
        return $this->render('index',[
                                      'equipo'=>$equipo,
                                      'estudiantes'=>$estudiantes,
                                      'invitacionContador'=>$invitacionContador,
                                      'invitacionContadorDocente'=>$invitacionContadorDocente,
                                      'institucion'=>$institucion,
                                      'docentes'=>$docentes]);
    }
    
    public function actionParticipante($q = null) {
        
        $participantes=  Estudiante::find()
                    ->where('nombres_apellidos like "%'.$q.'%"')
                    ->all();
        $out = [];
        foreach ($participantes as $participante) {
            $out[] = ['value' => $participante->id,'label' => $participante->nombres_apellidos." ".$participante->dni];
        }
        echo Json::encode($out);
    }
    
    public function actionActualizar($id)
    {
        $this->layout='estandar';
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$id])->one();
        $user=Usuario::findOne(\Yii::$app->user->id);
        $Comprobandolider=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$user->estudiante_id])->one();
        if(!$integrante || $Comprobandolider->rol==2)
        {
            $this->redirect(['panel/index']);
        }
        $equipo=Equipo::find()->where('id=:id',[':id'=>$integrante->equipo_id])->one();
        if(!$equipo->foto)
        {
            $equipo->foto='no_disponible.png';
        }
        
        $institucion=Institucion::find()
                    ->select('institucion.id,estudiante.id as estudiante_id,ubigeo.department_id')
                    ->innerJoin('estudiante','estudiante.institucion_id=institucion.id')
                    ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                    ->innerJoin('ubigeo','ubigeo.district_id=institucion.ubigeo_id')
                    ->where('usuario.id='.\Yii::$app->user->id.'')
                    ->one();
                    
        $estudiantes=Estudiante::find()
                    ->where('estudiante.grado!=6 and estudiante.institucion_id=:institucion_id and estudiante.id
                            not in (select invitacion.estudiante_invitado_id from invitacion
                                    inner join estudiante on estudiante.id=invitacion.estudiante_invitado_id
                                    where invitacion.equipo_id='.$equipo->id.' and invitacion.estado=1 and estudiante.grado!=6)
                            and estudiante.id
                            not in (select estudiante_id from integrante where equipo_id='.$equipo->id.') and estudiante.id!=:id
                            ',[':institucion_id'=>$institucion->id,':id'=>$institucion->estudiante_id])
                    ->orderBy('grado asc')->all();
                    
        $docentes=Estudiante::find()
                    ->where('estudiante.grado=6 and estudiante.institucion_id=:institucion_id and estudiante.id
                            not in (select invitacion.estudiante_invitado_id from invitacion
                                    inner join estudiante on estudiante.id=invitacion.estudiante_invitado_id
                                    where invitacion.estado=2 and estudiante.grado=6)
                            and estudiante.id
                            not in (select estudiante_id from integrante where equipo_id='.$equipo->id.') and estudiante.id!=:id
                            ',[':institucion_id'=>$institucion->id,':id'=>$institucion->estudiante_id])
                    ->orderBy('grado asc')->all();
                    
                    
                    
        $invitacionContadorDocente=Invitacion::find()
                            ->innerJoin('estudiante','estudiante.id=invitacion.estudiante_invitado_id')
                            ->where('invitacion.estado=1 and invitacion.equipo_id=:equipo_id and estudiante.grado=6',
                                              [':equipo_id'=>$equipo->id])->count();
        
        $integranteContadorDocente=Integrante::find()
                            ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                            ->where('integrante.equipo_id=:equipo_id and estudiante.grado=6',
                                              [':equipo_id'=>$equipo->id])->count();
                            
        $invitacionContadorDocente=$invitacionContadorDocente+$integranteContadorDocente;                    
                    
        $invitacionContador=Invitacion::find()
                            ->innerJoin('estudiante','estudiante.id=invitacion.estudiante_invitado_id')
                            ->where('invitacion.estado=1 and invitacion.equipo_id=:equipo_id and estudiante.grado!=6',
                                              [':equipo_id'=>$equipo->id])->count();
        
        $integranteContador=Integrante::find()
                            ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                            ->where('integrante.equipo_id=:equipo_id and estudiante.grado!=6',
                                              [':equipo_id'=>$equipo->id])->count();
        
        $invitacionContador=$invitacionContador+$integranteContador;
        if ($equipo->load(Yii::$app->request->post()) && $equipo->validate()) {
            $equipo->foto_img = UploadedFile::getInstance($equipo, 'foto_img');
            if($equipo->foto_img)
            {
                $equipo->foto=$equipo->id. '.' . $equipo->foto_img->extension; 
            }
            else
            {
                $equipo->foto=""; 
            }
            
            
            $equipo->update();
            if(isset($equipo->invitaciones))
            {
                $countInvitaciones=count($equipo->invitaciones);
                for($i=0;$i<$countInvitaciones;$i++)
                {
                    $invitacion=new Invitacion;
                    $invitacion->estudiante_id=$institucion->estudiante_id;
                    $invitacion->equipo_id=$equipo->id;
                    $invitacion->estudiante_invitado_id=$equipo->invitaciones[$i];
                    $invitacion->estado=1;
                    $invitacion->fecha_invitacion=date("Y-m-d H:i:s");
                    $invitacion->save();
                }
            }
            
            if(isset($equipo->invitaciones_docente))
            {
                $countInvitaciones=count($equipo->invitaciones_docente);
                for($i=0;$i<$countInvitaciones;$i++)
                {
                    $invitacion=new Invitacion;
                    $invitacion->estudiante_id=$institucion->estudiante_id;
                    $invitacion->equipo_id=$equipo->id;
                    $invitacion->estudiante_invitado_id=$equipo->invitaciones_docente[$i];
                    $invitacion->estado=1;
                    $invitacion->fecha_invitacion=date("Y-m-d H:i:s");
                    $invitacion->save();
                }
            }
            
            if($equipo->foto_img)
            {
                $equipo->foto_img->saveAs('foto_equipo/' . $equipo->id . '.' . $equipo->foto_img->extension);
            }
            
            //return $this->refresh();
            return $this->redirect(['panel/index']);
        }
        return $this->render('index',[
                                      'equipo'=>$equipo,
                                      'estudiantes'=>$estudiantes,
                                      'invitacionContador'=>$invitacionContador,
                                      'invitacionContadorDocente'=>$invitacionContadorDocente,
                                      'institucion'=>$institucion,
                                      'docentes'=>$docentes]);
    }

}
