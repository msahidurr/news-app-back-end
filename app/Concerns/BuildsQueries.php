<?php

namespace App\Concerns;

trait BuildsQueries
{
    public function scopeUserId($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function isActive(int $value = 0)
    {
        return $this->is_active == $value ? 'selected' : '';
    }

    public function getStatus()
    {
        if ($this->is_active) {
            return "<span class='badge badge-success'>Active</span>";
        }

        return "<span class='badge badge-danger'>Inactive</span>";
    }

    public function editButton($url)
    {
        return '<a href="'.$url.'" class="btn btn-light-primary btn-icon btn-sm me-2"><i class="fas fa-pen"></i></a>';
    }

    public function deleteButton($url)
    {
        $formId = 'destroy-form-'.$this->id;

        return "<a class='btn btn-light-danger btn-icon btn-sm me-2' href='#'
                onclick='event.preventDefault(); confirmDelete(`{$formId}`);'><i class='fas fa-times'></i>
            </a>

            <form id='{$formId}' action='".$url."' method='POST' class='d-none'>
                <input type='hidden' name='_token' value='".csrf_token()."'>
                <input type='hidden' name='_method' value='DELETE'>
            </form>";
    }
}
