NAME
    README - Castor Readme

DESCRIPTION
    This is the README file for Castor, release 0.3. 
    
    This program is in preliminary developpement stage,
    So there is still much to do, if you want to get involved,
    or if you find a bug,
    please send me an email to contact@akooe.com.
    You can also visit my site at :
    www.akooe.com/akooe.php3/castor.html
    you will find here the latest version.
    akooe is an experiment to create a meta search engine
    completly written in php.

  What is Castor?

    Castor is an url submiter engine, using php and a modified Snoopy version
    included in the distribution.
    Snoopy is a sourceforge project and is a class to simulate a http client
    (a browser).
    You will find an unmodified snoopy version at snoopy.sourceforge.net.
    Castor uses a data array to submit your url to various engines.
    actually I already done the job for :
    Altavista",AllTheWeb,aol,excite,google,hotbot,go,lycos,Northernlight
    webcrawler,Voila,Infomak,WebTop,Anzwers and Whatyouseek.
    Castor can be enhanced by adding yourself more data to the SUBMITDATA
    array. Feel free to do so and send back to me any new engine you add,
    it will be added to the distribution and you will be added to the list 
    of contributors.
    The Castor code is distributed under the GNU General Public License.

  Documentation

    Castor is a php class :
    the main method are :
    
    the constructor :
    castor($proxy_host="",  $proxy_port="") 
      in case you are behind a proxy
      where $proxy_host is the host name of your proxy
            $proxy_port is the port of your proxy
      the proxy feature has not been tested yet.
    processSubmit($params)
      the main routine
      where $params is an array containing :
        "url"      : the url of the site you want to submit
        "email"    : an email used by some engines to confirm you submission
        "submitto" : an array where the key is the engine name you wish to submit
                     the value is not used for now but use 1 if you want future compatibility.
    you will find an example of use in test.php.
  
  Data engine description
   
   SUBMITDATA is an array of search engine to submit to where
   the key is the name of the engine and the engine data is an
   array described below :
   
   "where"  => "somewhere.com"    
      the server where we post our request, only for information.
   "wzone"  => "WRD"
      the zone code of the country where the server is located (FR for france), onmy for information.
   "method" => "GET"
      the submit method used for request (not used yet).
   "url"    => "http://somewhere.com?q={url}&e={email}",
      the template url for submission where {url} is the url who wish to submit
      and {email} is the associated email.
   "success" => array ( "has been scheduled for addition" ),
      a set of strings displayed when the submission is successfull,
      found on the returned page of the engine after submission.
   "failure"=> array ( "Invalid URL", "URL was not added" )
      a set of strings displayed when the submission fail,
      found on the returned page of the engine after submission.    
    
AUTHOR
    Carmelo Guarneri. Last Modified May 8, 2000.

