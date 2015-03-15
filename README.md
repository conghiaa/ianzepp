=Ian Zepp's Open Source Projects=

This Google Code project is a collection of current and inactive open source software, primarily authored or managed by Ian Zepp <[mailto:ian.zepp@gmail.com ian.zepp@gmail.com]>. These projects are primarily in PHP, C++, and Java. Projects are listed below with short descriptions, and links to the Wiki pages where more information _may_ be found.

=IMPORTANT NOTICE:=

This entire project repository is wildly out of date, and hasn't been updated since 2008/2009. For further information about me (Ian Zepp), please see my Linked In page below:

[http://www.linkedin.com/in/ianzepp http://www.linkedin.com/in/ianzepp]

==Apache ActiveMQ Stomp==

This project is an integration effort at bringing the full power of Apache ActiveMQ to the PHP platform. It uses the text-based Stomp protocol to provide full messaging under the following patterns:

  * async send
  * async send/receive
  * sync send
  * sync send/receive

Using this is (almost) as simple as:

{{{
$connection = new Apache_ActiveMQ_Stomp_Connection;
$connection->setBrokerUri ("tcp://localhost:61613");
$connection->connect ();

// Send an asynchronous message
$connection->sendMessage ("/topic/testing.1", "Hello World!");

// Send an XML snippet, and get a response
$request = "<findAccountId id="2345" />";
$response = $connection->sendRequestResponse ("/queue/accounts.find", $request);

// The response now contains the body that the remote service sent back. Notice
// that we don't have to do any temporary queue management!

}}}

[http://code.google.com/p/ianzepp/source/browse/trunk/apache-activemq-stomp SVN Source Tree]

[http://activemq.apache.org/ External: Apache ActiveMQ]

[http://activemq.apache.org/stomp.html External: Apache ActiveMQ Stomp Protocol]

==Logging J2EE/Spring Service and Appender ==

This project is an implementation of a logging service using Java + Spring Framework. It is designed to receive XML messages from the associated Logging Appender project, as routed to it using a Mule ESB backbone.

Quite simple and straightforward. Does not use Hibernate or OpenJPA but direct JDBC + parameterized SQL instead. Thisproject is designed to be deployed to an Apache Geronimo server, but should work with any compliant J2EE application server.

[http://code.google.com/p/ianzepp/source/browse/trunk/logging-jms-service SVN Source Tree]

The Logging Appender is the flip side of the logging service. It provides a custom Log4j class to hook into log messages, and forward them to the logging service over JMS + Mule.

[http://code.google.com/p/ianzepp/source/browse/trunk/logging-jms-appender SVN Source Tree]

==Apache ActiveMQ Monitor==

This project is an attempt to build a generic C++/QT application that listens to ActiveMQ topics and manages messages. Already through several design and implementation revisions, this project is still a work in progress.

[http://code.google.com/p/ianzepp/source/browse/trunk/apache-activemq-monitor SVN Source Tree]

==Zend Framework==

Many of the PHP projects here depend on Zend, and Zend is most conveniently used as an external dependency. This project is a Maven-managed Zend distribution.

[http://code.google.com/p/ianzepp/source/browse/trunk/zend-framework-1.7.7-minimal SVN Source Tree (Zend Framework 1.7.7 Minimal)]

[http://www.zend.com External: Zend Framework Home Page]

[http://maven.apache.org External: Apache Maven]

[http://www.php-maven.org External: Apache Maven for PHP]

==Paymentech Ingestor==

This project is an interesting combination of Zend PHP + Maven. It uses the publicly available Chase Paymentech APIs for receiving credit card chargeback and void CSV files and converts them to a usable XML structure. 

In the process, it pulls in external files through Curl, Sftp, or a standard Stream Context, run a Gpg decryption against them, extracts the chargeback information from the CSV file, converts the data to an XML structure, validates the XML against a predefined XML Schema Definition, and them forwards the validated XML to a remote HTTP controller action.

This project is designed to run as a cronjob periodically, and uses Maven's support for profiles to automatically build and package a deployable bundle to different environments.

[http://code.google.com/p/ianzepp/source/browse/trunk/paymentech-ingestor SVN Source Tree]

==Logging Stream Context==

This project allows one to use a standard PHP stream context to send log messages and exception stack traces to an external JMS-based logging service.

For example:

{{{
require_once "Logging/Stream/Jms.php";
stream_wrapper_register ("logging", "Logging_Stream_Jms");

// Then you can use the following code anywhere to send log messages
file_put_contents ("logging://info", "This is an INFO-level message");

// Or you can pass through exceptions, which are automatically parsed to extract
// stack trace and file information.
try 
{
    ...
}
catch (Exception $exception)
{
    file_put_contents ("logging://warning", $exception);
}
}}}

[http://code.google.com/p/ianzepp/source/browse/trunk/logging-stream-context SVN Source Tree]

==Appenda==

Appenda is a collection of Object-Oriented PHP classes built along the Zend PHP namespace conventions, but using a dependency-injection development style modeled after the Spring Framework (from Java). In particular, the bean container in Appenda is designed to be significantly compliant with the Spring Bean definition schema. 

Appenda provides both a core package, and several sample service bundles. Appenda also integrates with both Maven and Zend to leverage the beauty of Maven dependency management.

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-base-datasource Appenda Base, Data Source API (very rough)]

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-base-message Appenda Base, Messaging]

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-base-property Appenda Base, Property / Attribute Management]

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-bundle-account Appenda Service Bundle, Account Management]

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-bundle-logging Appenda Service Bundle, Logging]

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-bundle-session Appenda Service Bundle, Sessions]

==Appenda Property==

This project deserves a long introduction. A property set is a collection of variables (or attributes), handled in a strict-type fashion.

*MAGIC METHODS*

Assuming the following attribute set and registered attributes:

{{{
$propertySet = new Appenda_Property_Set();
$propertySet->register ('Sample', 'String');
$propertySet->register ('Mapping', 'Array');
}}}

The following accessors and mutators are magically available:

{{{
$propertySet->getSample();
$propertySet->setSample ('Some Value');
}}}

The following basic array methods are available as well for array types:

{{{
$propertySet->getMapping ('Key');
$propertySet->setMapping ('Key', 'Value');
$propertySet->appendToMapping ('Value');
$propertySet->appendToMapping ('Key', 'Value');
$propertySet->prependToMapping ('Value');
$propertySet->prependToMapping ('Key', 'Value');
$propertySet->countMapping();
}}}

Inspection of internal properties are available:

{{{
$propertySet->inspectSample(); // Returns the internal Appenda_Property object.
}}}

The following value tests are available, and return true/false. While not shown,
all registered property types have access to these methods.

{{{
$propertySet->isSampleNull();
$propertySet->isSampleNotNull();
$propertySet->isSampleEmpty();
$propertySet->isSampleNotEmpty();
$propertySet->isSampleTrue();  // Strict type checking.
$propertySet->isSampleFalse(); // String type checking.
}}}

The following assertations are available, and throw an exception if ASSERT_BAIL is enabled, print a warning and return an Exception object if ASSERT_WARNING is enabled, or simply do nothing and return null is ASSERT_ACTIVE is off. While not shown, all registered property types have access to these methods.

{{{
$propertySet->assertSampleNull();
$propertySet->assertSampleNotNull();
$propertySet->assertSampleEmpty();
$propertySet->assertSampleNotEmpty();
$propertySet->assertSampleTrue();  // Strict type checking.
$propertySet->assertSampleFalse(); // Strict type checking.
}}}

*PROPERTY MODES*

Modes are used to control the behavior of individual attributes. The modes are:

  * MODE_ACCESSOR
  * MODE_ALIAS
  * MODE_CALLBACK
  * MODE_CALLBACK_CACHED
  * MODE_COMPRESSED
  * MODE_INTERNAL
  * MODE_LOCKED
  * MODE_MUTATOR
  * MODE_PERMISSIVE
  * MODE_SHARED

Modes are bitmapped values, so you can do a bitwise | operator to combine several modes
in a single method call. To apply a mode to a property:

{{{
$propertySet = new Appenda_Property_Set();
$propertySet->register ('Sample', 'string');
$propertySet->registerMode (Appenda_Property_Set::MODE_COMPRESSED);
}}}

*TEMPLATING*

This class has two main methods (registerInstance(), newInstance()) that allow
you to save a cloned instance of a validated Appenda_Property_Set, so you can recreate the instance in the future without incuring the validation cost again.

For example, a complex object might include 10-15 attributes, each of which have 1-3 modes and perhaps 1-3 rules. Each time any of the registerXX() methods are called, an extensive set of name, type, and mode validations are performed. This is done to ensure that the internal state of the attribute set remains intact at all times.

By calling the registerInstance() method after the first instance of a class, a validated
copy is saved, and subsequent instances can be created (fully initialized and validated) by using the newInstance() method.

This is a substantial performance savings, even for simple objects:

  * Using unit tests to benchmark, a simple attribute set with three attributes and no rules or modes shows an 80% decrease in creation time.
  * A complex attribute set with approximately 10 attributes, 5 modes, and 10 rules show an improvement of two orders of magnitude.

Registering and cloning template is quite simple...

*INHERITANCE*

The easiest way to use a Appenda_Property_Set is to inherit from it. This gives you full access to the magic get, set, is, and assertIs methods, as well as providing a clean way to initialize the attributes, rules, and modes. For example:

{{{
class WebsiteRequest extends Appenda_Property_Set
{
    protected function __construct()
    {
        $this->register ('Host', 'string');
        $this->register ('RequestUrl', 'string');
        $this->registerTemplate (__CLASS__);
    }

    static public function newInstance (array $aRequestParams)
    {
        // Create or clone the template instance
        $oInstance = parent::newInstance (__CLASS__);

        // Update the internal attributes
        $oInstance->setHost ($aRequestParams['REQUEST_HOST']);
        $oInstance->setRequestUrl ($aRequestParams['REQUEST_URI'));

        // Development-time assertations
        $oInstance->assertHostNotEmpty();
        $oInstance->assertRequestUrlNotEmpty();

        // Return the validated instance
        return $oInstance;
    }
}
}}}

*FILTERS*

Filters are a special set of conditions that are tested prior to the updating of a property's
value. All filters must return true for the value to be updated. You can assign any number of
filters, in any combination of the following, with multiple filters of the same type allowed:

  * Appenda_Property_Filter::CALLBACK
  * Appenda_Property_Filter::INVERSE_REGEX
  * Appenda_Property_Filter::MAXIMUM
  * Appenda_Property_Filter::MINIMUM
  * Appenda_Property_Filter::REGEX
  * Appenda_Property_Filter::UNSIGNED

Most notably, callback filters can be assigned, so you can pass the data through an external
function someplace for validation.

Filters can be set directly using the Appenda_Property_Set class:

{{{
$propertySet = new Appenda_Property_Set();
$propertySet->register ('RangedInteger', 'Integer');
$propertySet->appendFilter ('RangedInteger', Appenda_Property_Filter::MINIMUM, -10);
$propertySet->appendFilter ('RangedInteger', Appenda_Property_Filter::MAXIMUM, +10);

$propertySet->register ('RangedString', 'String');
$propertySet->appendFilter ('RangedString', Appenda_Property_Filter::MINIMUM, 4);
$propertySet->appendFilter ('RangedString', Appenda_Property_Filter::MAXIMUM, 8);

// A more complicated example:
//
// Note the multiple regex rules. In this case, BOTH regexes have to match, which
// effectively means that the password has to have both at least one number and one
// letter, and the password as a whole also has to have a minimum length of 8
// characters and a maximum of 100.

$propertySet->register ('PasswordString', 'String');
$propertySet->appendFilter ('PasswordString', Appenda_Property_Filter::MINIMUM, 8);
$propertySet->appendFilter ('PasswordString', Appenda_Property_Filter::MAXIMUM, 100);
$propertySet->appendFilter ('PasswordString', Appenda_Property_Filter::REGEX, '/[a-zA-Z]+/');
$propertySet->appendFilter ('PasswordString', Appenda_Property_Filter::REGEX, '/[0-9]+/');
}}}

Filters can also be set and accessed on the individual Appenda_Property itself, using
the inspectPropertyName() and then accessing the 'Filters' field:

{{{
$oProperty = $propertySet->register ('PasswordString', 'String');
$oProperty->appendToFilters (...);
$oProperty->getFilters();
$oProperty->setFilters (...);
}}}

*TRIGGERS*

Triggers are similar to filters, but are exclusively callbacks that are executed in
order after the field is updated. No return value or success/failure is checked.

Triggers are added in a similar fashion to filters:

{{{
$propertySet = new Appenda_Property_Set();
$propertySet->register ('OrderStatus', 'Integer');
$propertySet->appendTrigger ('OrderStatus', array ('AuditHandler', 'logOrderChange'));
$propertySet->appendTrigger ('OrderStatus', array ('OrderHandler', 'updateStatus'));
}}}

[http://code.google.com/p/ianzepp/source/browse/trunk/appenda-property SVN Source Tree]

==Kmap 0.6.1 / 0.7.1==

Kmap is a old project of mine from around 1999-2000. It provided a front-end to the popular Nmap scanning software. It was built in C++/QT and integrated with the KDE desktop.

[http://code.google.com/p/ianzepp/source/browse/trunk/kmap-0.6.1 SVN Source Tree (version 0.6.1)]

[http://code.google.com/p/ianzepp/source/browse/trunk/kmap-0.7.1 SVN Source Tree (version 0.7.1)]


==Koog Epsilon==

Koog Epsilon is another old C++/QT project from around 1999. This project provided a UI interface to the Napster file-sharing servers that were popular at the time.

[http://code.google.com/p/ianzepp/source/browse/trunk/koog-epsilon SVN Source Tree]

==Gnutella Library==

This is an old Python project, also from the late 1990's, that provides a command line interface to the Gnutella file-sharing protocol.

[http://code.google.com/p/ianzepp/source/browse/trunk/gnutellalib SVN Source Tree]
