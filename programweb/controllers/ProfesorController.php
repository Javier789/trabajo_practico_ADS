<?php

namespace app\controllers;

use Yii;
use app\models\Profesor;
use app\models\ProfesorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfesorController implements the CRUD actions for Profesor model.
 */
class ProfesorController extends Controller {

    public $multichain_chain;
    public $multichain_getinfo;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profesor models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProfesorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profesor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profesor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Profesor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idProfesor]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profesor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idProfesor]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Profesor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPublicar() {

        $config = $this->read_config();
        $chain = 'default';
        $result = "";
        if (strlen($chain))
            $name = @$config[$chain]['name'];
        else
            $name = '';

        $this->set_multichain_chain($config[$chain]);

        //if ($this->multichain_has_json_text_items()) { // use native JSON and text objects in MultiChain 2.0
        //$json = \yii::$app->request->post();
        $json = '{idMateria: 1, idAlumno: 2, descripcion: "Primer Parcial", nota: 9}';
        var_dump($json);
        $data = array('json' => $json);
        $keys = "key";
        $result = $this->multichain('publishfrom', '1X16ceuJcY8U3jn1qiJjS2UGob459omnqkRMGX', 'stream1', $keys, $data);

        // }
            var_dump($result);
        return;
    }

    /**
     * Finds the Profesor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Profesor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function multichain_has_json_text_items() {
        return $this->multichain_has_protocol(20001);
    }

    protected function multichain_has_protocol($version) {
        $getinfo = $this->multichain_getinfo();

        return $getinfo['protocolversion'] >= $version;
    }

    function read_config() {
        $config = array();

        $contents = file_get_contents('C:\Users\Usuario\OneDrive\UNIVERSIDAD\ASW\repo_local\programweb\views\site\config.txt');
        $lines = explode("\n", $contents);

        foreach ($lines as $line) {
            $content = explode('#', $line);
            $fields = explode('=', trim($content[0]));
            if (count($fields) == 2) {
                if (is_numeric(strpos($fields[0], '.'))) {
                    $parts = explode('.', $fields[0]);
                    $config[$parts[0]][$parts[1]] = $fields[1];
                } else {
                    $config[$fields[0]] = $fields[1];
                }
            }
        }

        return $config;
    }

    function set_multichain_chain($chain) {
        $this->multichain_chain = $chain;
    }

    function multichain_getinfo() {
        if (!is_array($this->multichain_getinfo))
            $this->no_displayed_error_result($this->multichain_getinfo, $this->multichain('getinfo'));

        return $this->multichain_getinfo;
    }

    function multichain($method) { // other params read from func_get_args()
        $args = func_get_args();
        return $this->json_rpc_send($this->multichain_chain['rpchost'], $this->multichain_chain['rpcport'], $this->multichain_chain['rpcuser'], $this->multichain_chain['rpcpassword'], $method, array_slice($args, 1));
    }

    function json_rpc_send($host, $port, $user, $password, $method, $params = array(), &$rawresponse = false) {
        if (!function_exists('curl_init')) {
            output_html_error('This web demo requires the curl extension for PHP. Please contact your web hosting provider or system administrator for assistance.');
            exit;
        }

        $url = 'http://' . $host . ':' . $port . '/';

        $payload = json_encode(array(
            'id' => time(),
            'method' => $method,
            'params' => $params,
        ));

        //	echo '<PRE>'; print_r($payload); echo '</PRE>';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ));

        $response = curl_exec($ch);

        if ($rawresponse !== false)
            $rawresponse = $response;

        var_dump($response);


        $result = json_decode($response, true);

        if (!is_array($result)) {
            $info = curl_getinfo($ch);
            $result = array('error' => array(
                    'code' => 'HTTP ' . $info['http_code'],
                    'message' => strip_tags($response) . ' ' . $url
            ));
        }

        return $result;
    }

    function no_displayed_error_result(&$result, $response) {
        if (is_array($response['error'])) {
            $result = null;
            $this->output_rpc_error($response['error']);
            return false;
        } else {
            $result = $response['result'];
            return true;
        }
    }

    function output_rpc_error($error) {
        $this->output_html_error($error['code'] . '<br/>' . $error['message']);
    }

    function output_html_error($html) {
        echo '<div class="bg-danger" style="padding:1em;">Error: ' . $html . '</div>';
    }

}
