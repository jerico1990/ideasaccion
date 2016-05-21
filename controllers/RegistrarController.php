<?php

namespace app\controllers;

use Yii;
use app\models\Registrar;
use app\models\Estudiante;
use app\models\Encuesta;
use app\models\Usuario;
use app\models\Participante;
use app\models\ParticipanteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class RegistrarController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
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
        $this->layout='registrar';
        $registrar= new Registrar;
        
        if ($registrar->load(Yii::$app->request->post()) && $registrar->validate()) {
            /*if(Estudiante::find()->where('email=:email',[':email'=>$registrar->email])->one())
            {
                Yii::$app->session->setFlash('emailexistente');
                return $this->refresh();
            }
            else if(Estudiante::find()->where('dni=:dni',[':dni'=>$registrar->dni])->one())
            {
                Yii::$app->session->setFlash('dniexistente');
                return $this->refresh();
            }
            else
            {*/
                $fecha_nacimiento=str_replace("/", "-", $registrar->fecha_nac);
                $registrar->foto = UploadedFile::getInstance($registrar, 'foto');
                $estudiante =new Estudiante;
                $estudiante->nombres=$registrar->nombres;
                $estudiante->apellido_paterno=$registrar->apellido_paterno;
                $estudiante->apellido_materno=$registrar->apellido_materno;
                $estudiante->sexo=$registrar->sexo;
                $estudiante->dni=$registrar->dni;
                $estudiante->fecha_nac=date("Y-m-d",strtotime($fecha_nacimiento));
                $estudiante->email=$registrar->email;
                $estudiante->celular=$registrar->celular;
                $estudiante->institucion_id=$registrar->institucion;
                $estudiante->grado=$registrar->grado;
                $estudiante->save();
                
                $usuario=new Usuario;
                $usuario->username=$registrar->email;
                $usuario->password=Yii::$app->getSecurity()->generatePasswordHash($registrar->password);//crypt($registrar->password,"ideasenaccion");
                $usuario->status=1;
                $usuario->fecha_registro=date("Y-m-d H:i:s");
                $usuario->estudiante_id=$estudiante->id;
                $usuario->save();
                
                $subject="Bienvenido a la plataforma de ideas en acción";
                $content="¡Bienvenido a ideas en acción!<br><br>
                         Ahora podrás ingresar a tu propia cuenta en la plataforma con estos datos:
                         <br><br>
                         <b>Usuario:</b> $usuario->username <br>
                         <b>Contraseña:</b> $registrar->password<br><br>
                         <br>
                         Haz clic en este <a href='http://intranet.ideasenaccion.pe/site/login'>link</a> para poder ingresar a la plataforma.
                         ";
                Yii::$app->mail->compose('@app/mail/layouts/html',['content'=>$content])
               ->setFrom('info@ideasenaccion.pe')
               ->setTo($registrar->email)
               ->setSubject($subject)
               ->send();
                
                /*$ruta=new Ruta;
                $ruta->user_id=$usuario->id;
                $ruta->etapa_1=1;
                $ruta->etapa_2=1;
                $ruta->save();*/
                /*$encuesta=new Encuesta;
                $encuesta->estudiante_id=$estudiante->id;
                if(isset($registrar->p1[0]))
                {
                    $encuesta->p1_1=$registrar->p1[0];
                }
                if(isset($registrar->p1[1]))
                {
                    $encuesta->p1_2=$registrar->p1[1];
                }
                if(isset($registrar->p1[2]))
                {
                    $encuesta->p1_3=$registrar->p1[2];
                }
                if(isset($registrar->p1[3]))
                {
                    $encuesta->p1_4=$registrar->p1[3];
                }
                
                if(isset($registrar->p2))
                {
                    $encuesta->p2=$registrar->p2;
                }
                
                if(isset($registrar->p3[0]))
                {
                    $encuesta->p3_1=$registrar->p3[0];
                }
                if(isset($registrar->p3[1]))
                {
                    $encuesta->p3_2=$registrar->p3[1];
                }
                if(isset($registrar->p3[2]))
                {
                    $encuesta->p3_3=$registrar->p3[2];
                }
                if(isset($registrar->p3[3]))
                {
                    $encuesta->p3_4=$registrar->p3[3];
                }
                if(isset($registrar->p3[4]))
                {
                    $encuesta->p3_5=$registrar->p3[4];
                }
                if(isset($registrar->p3[5]))
                {
                    $encuesta->p3_6=$registrar->p3[5];
                }
                
                
                if(isset($registrar->p4[0]))
                {
                    $encuesta->p4_1=$registrar->p4[0];
                }
                if(isset($registrar->p4[1]))
                {
                    $encuesta->p4_2=$registrar->p4[1];
                }
                if(isset($registrar->p4[2]))
                {
                    $encuesta->p4_3=$registrar->p4[2];
                }
                if(isset($registrar->p4[3]))
                {
                    $encuesta->p4_4=$registrar->p4[3];
                }
                if(isset($registrar->p4[4]))
                {
                    $encuesta->p4_5=$registrar->p4[4];
                }
                if(isset($registrar->p4[5]))
                {
                    $encuesta->p4_6=$registrar->p4[5];
                }
                
                if(isset($registrar->p5[0]))
                {
                    $encuesta->p5_1=$registrar->p5[0];
                }
                if(isset($registrar->p5[1]))
                {
                    $encuesta->p5_2=$registrar->p5[1];
                }
                
                
                if(isset($registrar->p6[0]))
                {
                    $encuesta->p6_1=$registrar->p6[0];
                }
                if(isset($registrar->p6[1]))
                {
                    $encuesta->p6_2=$registrar->p6[1];
                }
                if(isset($registrar->p6[2]))
                {
                    $encuesta->p6_3=$registrar->p6[2];
                }
                if(isset($registrar->p6[3]))
                {
                    $encuesta->p6_4=$registrar->p6[3];
                }
                
                $encuesta->save();*/
                
                if($registrar->foto)
                {
                    $registrar->foto->saveAs('foto_personal/' . $usuario->id . '.' . $registrar->foto->extension);
                    $usuario->avatar=$usuario->id. '.' . $registrar->foto->extension;
                }
                else
                {
                    $usuario->avatar="no_disponible.jpg";
                }
                
                $usuario->update();
                Yii::$app->session->setFlash('registrar');
                
                
                
                //return $this->refresh();
                //return $this->refresh();
                return $this->redirect(['site/login']);
            //}
        }
        
        
        return $this->render('index',['registrar'=>$registrar]);
    }

    /**
     * Displays a single Participante model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Participante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Participante();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Participante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Participante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Participante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Participante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Participante::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionValidardni()
    {
        if(isset($_POST['dni'])){
            $dni=$_POST['dni'];
            $estudiante=Estudiante::find()->where('dni=:dni',[':dni'=>$dni])->one();
            if($estudiante)
            {
                echo 1;
            }
            else
            {
                echo 0;
            }
        }
        else
        {
            $this->redirect(['registrar/index']);
        }
    }
    
    public function actionValidaremail()
    {
        if(isset($_POST['email'])){
            $email=$_POST['email'];
            $estudiante=Estudiante::find()->where('email=:email',[':email'=>$email])->one();
            if($estudiante)
            {
                echo 1;
            }
            else
            {
                echo 0;
            }
        }
        else
        {
            $this->redirect(['registrar/index']);
        }
    }
    
    public function actionGuardar()
    {
        var_dump($_POST);
    }
    
    public function actionPrueba()
    {
        $this->layout='equipobk';
        return $this->render('prueba');
    }
}
