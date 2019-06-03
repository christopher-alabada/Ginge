<?php
/**
 * Simple example of Ginge
 *
 * - Set $template variable
 * - Set $data variable
 * - Require Autoload.php file
 * - Instantiate Ginge
 * - Call render($template, $data)
 * - Done
 **/

/**
 * The template variable. You can also pass the full path of a template
 * with this data.
 */
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


// The data variable
$data = [
  'page_name' => 'Ginge Example',
  'header' => __DIR__ . '/templates/header.tpl',
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
  'footer' => __DIR__ . '/templates/footer.tpl',
  'analytics' => 'Blah blah blah code'
];

require_once dirname(__DIR__) . "/src/Autoload.php";

$Ginge = new Ginge\Ginge();
echo $Ginge->render($template, $data);
