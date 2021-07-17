<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ["url_base"];

	private $registros = array("5", "2", "10", "25", "50", "100");

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}

	public function indexview($model, $controllerName)
	{
		$data['registros'] = 5;
		$data['registrosList'] = $this->registros;
		$data['pagina'] = 1;
		$data['buscar'] = "";
		$data['orderBy'] = $this->request->getPost('orderBy');

		if ($this->request->getMethod() === 'post') {
			if ($this->request->getPost('registros') != null)
				$data['registros'] = $this->request->getPost('registros');
			if ($this->request->getPost('pagina') != null)
				$data['pagina'] = $this->request->getPost('pagina');
			if ($this->request->getPost('buscar') != null)
				$data['buscar'] = $this->request->getPost('buscar');
		}
		$data['offset'] = $data['pagina'] * $data['registros'] - $data['registros'];
		if ($this->request->getPost('buscar') != null) {
			$data[$controllerName] = $model->search($this->request->getPost('buscar'), $data['registros'], $data['offset'], $data['orderBy']);
			$data['totalItems'] = $model->countSearch($this->request->getPost('buscar'));
		} else {
			$data[$controllerName] = $model->find($data['registros'], $data['offset'], $data['orderBy']);
			$data['totalItems'] = $model->count();
		}

		$data['numPaginas'] = ceil($data['totalItems'] / $data['registros']);
		$data['disabilitaAnterior'] = $data['pagina'] == 1;
		$data['disabilitaProximo'] = $data['pagina'] == $data['numPaginas'];
		return $data;
	}
}
