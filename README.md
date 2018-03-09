i22 Functional Test Bundle
==========================

A [Symfony](http://symfony.com) bundle to simplify functional testing with the help of 
[AliceBundle](https://github.com/hautelook/AliceBundle).

Table of contents:
- [Installation](#installation)
- [Basic usage](#basic-usage)
    - [Seperate fixture files](#loading-fixtures-for-each-test-class)
    - [Authorize User](#authorize-user)
    - [Fake Translator](#no-translator---working-with-translation-keys)
    - [Disabling Csrf Form Protection](#disabled-auto-csrf-protection-for-forms)


Installation
------------

  1. Download the Bundle
  
  ```bash
  $ composer require --dev i22/functional-test-bundle
  ```
  
  2. Enable the Bundle
  
  With Symfony 3.x adding the Bundle to `app/AppKernel.php`
  
  ```php
  <?php
   
  class AppKernel extends Kernel
  {
      public function registerBundles()
      {
          // ...
          if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
              // ...
              if ('test' === $this->getEnvironment()) {
                  $bundles[] = new I22\FunctionalTestBundle\I22FunctionalTestBundle();
              }
          }

          return $bundles;
      }
      
      // ...
  }
  ```
  
  With Symfony 4.x adding the Bundle to `config/bundles.php`\
  (Should be done with auto-configuration, but activated for all environments)
  
  ```php
  <?php 
   
  return [
      // ...
      I22\FunctionalTestBundle\I22FunctionalTestBundle::class => ['test' => true],
  ];
  
  ```
  
Basic usage
===========

Loading fixtures for each test class
------------------------------------------------
  
  Instead of setting up the database with one big fixture file for all tests you can define seperate small
  fixture-sets customized for your test case.
  
  Setup your Test Class to extend from WebTestCase
  
  ```php
  <?php
  
  use I22\FunctionalTestBundle\Test\WebTestCase;
  
  class MyControllerTest extends WebTestCase
  {
      
  }
  ```
  
  In order to load your customized fixtures automatically place a fixture folder with your fixtures beneath
  your test file
  
  ```
  .
  └── tests/
      ├── ...
      └── Controller/
          └── MyControllerTest/
                ├── fixtures/
                ├   ├── users.yaml 
                ├   ├── ...
                └── MyControllerTest.php
  ```
  
  If you want do define from where to load your fixtures, you can override the method `getFixtureFilePaths()`
  
  ```php
    <?php
    
    use I22\FunctionalTestBundle\Test\WebTestCase;
    
    class MyControllerTest extends WebTestCase
    {
        protected function getFixtureFilePaths() : array
        {
            return [
                __DIR__.'/../../global-fixtures/users.yaml',                
            ];
        }
    }
  ```
  
Authorize User
--------------
  
  in case u need to authorize a user for your functional test, you can use the UserAuthorizationTrait
  to login the user.
  
  ```php
      <?php
      
      use I22\FunctionalTestBundle\Security\Authorization\UserAuthorizationTrait;
      use I22\FunctionalTestBundle\Test\WebTestCase;
      
      class MyControllerTest extends WebTestCase
      {
          use UserAuthorizationTrait;
          
          public function setUp()
              {
                  parent::setUp();
                  $user = $this->getDoctrine()->getRepository('App:User')->findOneBy(['email' => 'test@i22.de']);
                  $this->login($user);
              }
      }
  ```
  
  the login method assumes that your firewall is named 'default'. in other cases use the second argument
  of the login method to specify how your firewall is named.
  
No Translator - working with translation keys
------------------------------------------------
  
  the bundle autoconfigures a FakeTranslator in test environment as the @default.translator service, so 
  that instead of translating your translation keys, the translator will respond the original key.
  
  for testing purpose it is usefull to test against the key instead of changing translations.
  
  if you want to disable this feature, change the default configuration as follows:
  
  ```yaml
  #config/packages/test/i22_functional_test.yaml
   
  i22_functional_test:
      use_fake_translator: false
  ```
  
Disabled auto csrf protection for forms
---------------------------------------
  
  the bundle autoconfigures the symfony form with disabling the auto protection of forms instead of disabling 
  the whole csrf protection services. so you are able to still use the csrf token manager to generate and use
  tokens for validation, but it simplifies the form post handling, because you dont need to add the _token value
  
  if you want to disable this feature, change the default configuration as follows:
  
  ```yaml
    #config/packages/test/i22_functional_test.yaml
     
    i22_functional_test:
        disable_csrf_form_protection: false
  ```
 