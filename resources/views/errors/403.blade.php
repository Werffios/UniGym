@extends('errors::minimal')

@section('title', __('messages.Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'messages.Forbidden'))
