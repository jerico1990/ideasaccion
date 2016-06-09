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
use yii\web\UploadedFile;

/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class RegistrarController extends Controller
{
    public function behaviors()
    {
        return [
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
                
                /*
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
               ->setFrom('info2@ideasenaccion.pe')
               ->setTo($registrar->email)
               ->setSubject($subject)
               ->send();
                */
                
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
}
