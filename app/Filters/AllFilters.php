<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AllFilters implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('is_Login')) {
            if (session()->get('level') == "Jemaat") {
            } else if (session()->get('level') == "Admin") {
            } else if (session()->get('level') == "Administrator") {
            } else {
                throw \App\Exceptions\ServiceUnavailableException::forServerDow();
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
