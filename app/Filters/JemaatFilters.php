<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JemaatFilters implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('is_Login')) {
            if (session()->get('level') != "Jemaat") {
                throw \App\Exceptions\ServiceUnavailableException::forServerDow();
                // throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                // echo 'Access denied';
                // exit;
            }
        } else {
            return redirect()->to(base_url('/login?#'));
        }
    }
    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
