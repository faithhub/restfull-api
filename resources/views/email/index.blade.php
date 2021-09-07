@component('mail::message')
Hi
{{-- use double space for line break --}}
{{-- Please click on the below link to reset your password --}}
{{-- Thank you for choosing Mailtrap! --}}
<p>A new post have been post on <a href="">{{$website_name}}</a></p>

<h3>Post Title: <br> {{$title}}</h3>
<h3>Post Description:</h3>
<p>{{$description}}</p>
Regards,  <br>
<b>{{config('app.name')}}</b>
@endcomponent