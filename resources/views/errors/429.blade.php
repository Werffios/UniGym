@extends('errors::minimal')

@section('title', __('messages.Too Many Requests'))
@section('code', '429')
@section('message', __('messages.Too Many Requests'))
