<?php
/**
 * Complete Test
 */
use PHPUnit\Framework\TestCase;

class CompleteTest extends TestCase
{
  public function testEverything() {
    $template = <<<TPL
<html>
<head>
  <title>Test {!page_name}</test>
</head>

<body>
  {!template : header}

  <div>
    {!foreach : users as user}
      <div class="firstname">{!user.firstname}</div>
      <div class="lastname">{!user.lastname}</div>
      {!if : user.emails}
        {!foreach : user.emails as email}
          <div class="email_{!_count}">{!email}</div>
        {!endforeach}
      {!endif}
    {!endforeach}
  </div>

  {!template : footer}
</body>
</html>
TPL;

    $data = [
      'page_name' => 'Ginge Example',
      'header' => __DIR__ . '/assets/header.tpl',
      'header_image' => 'http://someimage.com/image/png',
      'users' => [
        [
          'firstname' => 'Jon',
          'lastname' => 'Snow',
          'emails' => [
            'jon@snow.com',
            'jon@nightswatch.com'
          ]
        ],
        [
          'firstname' => 'Arya',
          'lastname' => 'Stark',
          'emails' => [
            'arya@stark.com'
          ]
        ],
        [
          'firstname' => 'Peter',
          'lastname' => 'Griffin',
          'emails' => [
            'peter@griffin.com'
          ]
        ],
        [
          'firstname' => 'Clayton',
          'lastname' => 'Kershaw',
          'emails' => [
            'clayton@kershaw.com'
          ]
        ],
      ],
      'footer' => __DIR__ . '/assets/footer.tpl',
      'analytics' => 'Blah blah blah code'
    ];

    $expected = '<html>
<head>
  <title>Test Ginge Example</test>
</head>

<body>
<header>
  <div>Welcome to my site!</div>
  <div><img src="http://someimage.com/image/png"></div>
</header>


  <div>
      <div class="firstname">Jon</div>
      <div class="lastname">Snow</div>
          <div class="email_1">jon@snow.com</div>
          <div class="email_2">jon@nightswatch.com</div>
      <div class="firstname">Arya</div>
      <div class="lastname">Stark</div>
          <div class="email_1">arya@stark.com</div>
      <div class="firstname">Peter</div>
      <div class="lastname">Griffin</div>
          <div class="email_1">peter@griffin.com</div>
      <div class="firstname">Clayton</div>
      <div class="lastname">Kershaw</div>
          <div class="email_1">clayton@kershaw.com</div>
  </div>
<footer>
  <div class="small_font">Copyright 2019</div>
</footer>

<script>
Blah blah blah code
</script>


</body>
</html>';

    $G = new Ginge\Ginge();
    $this->assertSame($expected, $G->render($template, $data));
  }
}