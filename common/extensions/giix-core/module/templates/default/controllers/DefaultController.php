<?php echo "<?php\n"; ?>

class DefaultController extends Controller
{
	public $layout;
	
	public function init(){
		$this->layout = $this->module->layout;
	}

	public function actionIndex()
	{
		$this->render('index');
	}
}