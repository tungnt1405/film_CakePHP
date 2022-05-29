<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

class CountriesController extends AdminController
{
    public function index()
    {
        $countries = $this->paginateAll($this->Countries);

        $this->set(compact('countries'));
    }

    public function view($id = null)
    {
        $search = $this->request->getQuery('query');
        $result = $this->Countries->search($search);

        $countries =  null;
        if($result){
            $countries = $this->paginateSearch($result);
        } else{
            $countries = '';
        }

        $this->set(compact('countries'));
    }

    public function add()
    {
        $country = $this->Countries->newEmptyEntity();
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if($this->Countries->save($country)){
                $this->Flash->success(__('success'));
                return $this->redirect(['_name'=>'admin_countries_add']);
            }else{
                $this->set('error','Thêm không thành công! Vui lòng thử lại');
            }
        }
        $this->set(compact('country'));
    }

    public function edit($id = null)
    {
        $slug = $this->request->getParam('slug');
        
        $country = $this->Countries->getSlugOfCountries($slug);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            $country->modified = date("Y-m-d");
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('success'));
                return $this->redirect(['_name'=>'admin_countries_edit','slug'=>$country->country_slug]);
            }
            else{
                $this->set('error','Cập nhật không thành công! Vui lòng thử lại');
            }
        }
        $this->set(compact('country'));
    }

    public function delete($id = null)
    {
        $id = $this->request->getParam('id');
        $this->request->allowMethod(['post', 'delete']);
        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            $this->Flash->success(__('success'));
            return $this->redirect(['_name'=>'admin_countries_home']);
        } else {
            $this->set('error','Xóa không thành công! Vui lòng thử lại');
        }

    }
}
