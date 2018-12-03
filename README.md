# Coding Challenge

---
## Inhoudsopgave
- [Inleiding](##Inleiding)  
- [De opdracht](##De%20opdracht)  
- [Onderzoek](##Onderzoek)  
- [Uitwerking](##Uitwerking)  
- [Documentatie](##Documentatie)  
- [PHPUnit test](##PHPUnit%20test)  

## Inleiding
Dit is de uitwerking voor de Coding Challenge.

## De opdracht
De opdracht is als volgt geformuleerd;  

> You are required to create a small command-line utility to help a fictional company determine the dates they need to pay salaries to their sales department.
   
## Onderzoek
Onder normale omstandigheden zou ik als eerste op internet zoeken neer relevante (deel-)projecten. 
Vaak zijn er soortgelijke projecten te vinden, waardoor we niet opnieuw het wiel hoeven uit te vinden. Of waardoor we op goede ideeen kunnen komen.

Ook is dit het moment om te bekijken of er nieuwe technologien zijn, die hier een aanvullende waarde zouden kunnen toevoegen.
## Uitwerking
Hieronder staan de stappen beschreven, die ik heb genomen om tot het geleverde resultaat te komen.
1. Requirement vluchtig doorgelezen
1. Gezocht op internet of er al een bestaande oplossing bestaat. (*Met moeite overgeslagen, want ik wilde het zelfstandig doen*)
1. Bepaal de script taal:
    1. Bash code (mogelijk beste keus voor een command line utility)
    1. MySQL code (verkeerde intrepretatie requirement)
    1. PHP 
    1. PHP Object Oriented
    1. JavaScript
    1. Ruby (te weinig ervaring mee om uit te werken)
    1. Phyton (te weinig ervaring mee om uit te werken)
1. Requirement bestudeert
1. Deelopdrachten bepaalt:
    1. Bepaal voor welke maanden de betaaldata moeten worden weergegeven
    1. Bepaal de datum waarop de lonen worden betaald voor een gegeven maand
    1. Bepaal de datum waarop de bonussen worden betaald voor een gegeven maand
    1. Maak van de data een CSV
1. Gezien het achterliggende doel (kennistest developer) besloten om project te ontwikkelen in PHP
1. Proof of Concept ontwikkeld (procedurele variant)
    1. Bij een presentatie in december komt er slechts 1 regel in de CSV. Hiervoor gelden niet alle uitzonderingen. Besloten om een uitbreiding te ontwikkelen die een CSV genereert voor een compleet jaar, dat als extra parameter mee te geven is.
    1. Ter controle op de kalender gekeken welke uitkomsten er verwacht werden.
    1. Niet geheel duidelijk; Betaling van de bonus gebeurt in de volgende maand. Welke datum wil de opdrachtgever weergeven, de betaaldata in een bepaalde maand of de data waarop een periode uitgekeerd moet worden. (*Gekozen voor de makkelijkste optie*) 
    1. In het requirement staat 'tot het einde van het jaar'. Dit zou betekenen dat na de betaaldatum van een bonu, deze niet meer weergegeven  moet worden. (*Gekozen om de lopende maand weer te geven met twee bijbehorende betaaldata*)
1. Extra research uitgevoerd op DateTime object
1. Testresultaten uitgewerkt (aan de hand van de kalender)
1. Unittesten en scripts ontwikkeld
1. Mogelijke uitbreidingen (*bijverkoop*):
    1. Grafische interface (website)
    1. Mogelijkheid om nationale feestdagen ook als weekend te bestempelen, zodat de betaaldata 'aangepast' worden
    1. Datum in CSV formateren

## Documentatie
In verband met het feit dat de ontwikkelomgeving mijn NAS is en daar nog geen PHP 7 op draait was ik genoodzaakt om geen typecasting toe te passen.
Bij een project op basis van PHP 7 zou ik dat uiteraard wel doen.

### Commando's
De volgende commando's kunnen worden gebruikt om de procedurele versie te starten;
```
php SalaryPaymentDateTool.php
php SalaryPaymentDateTool.php salary-dates.csv
php SalaryPaymentDateTool.php more-salary-dates.csv 2020
```
De object oriented versie kan gestart worden met;
```
php app.php
php app.php salary-dates.csv
php app.php more-salary-dates.csv 2020
```

### Voorbeelden

Bij aanroepen in december 2018 ziet het CSV bestand er als volgt uit;
```
Month,"Salary payment date","Bonus payment date"
December,2018-12-31,2018-12-19
```
Bij aanroepen in november 2019 ziet het CSV bestand er als volgt uit;
```
Month,"Salary payment date","Bonus payment date"
November,2019-11-29,2019-11-15
December,2019-12-31,2019-12-18
```
Het complete overzicht voor 2019 ziet er als volgt uit;
```
Month,"Salary payment date","Bonus payment date"
January,2019-01-31,2019-01-15
February,2019-02-28,2019-02-15
March,2019-03-29,2019-03-15
April,2019-04-30,2019-04-15
May,2019-05-31,2019-05-15
June,2019-06-28,2019-06-19
July,2019-07-31,2019-07-15
August,2019-08-30,2019-08-15
September,2019-09-30,2019-09-18
October,2019-10-31,2019-10-15
November,2019-11-29,2019-11-15
December,2019-12-31,2019-12-18
```
Deze data is bijvoorbeeld te controleren op 
https://www.kalender-365.nl/kalender-2019.html
## PHPUnit test
Voor alle gebruikte classen is er ook een unittest geschreven, op basis van PHPUnit. 

## PHPUnit test resultaat
Op het moment van schrijven van dit document levert het test commando 
`php /Vendors/phpunit-5.6.2.phar --configuration ./Tests/phpunit.xml  --testdox` het volgende resultaat op:
```
PHPUnit 5.6.2 by Sebastian Bergmann and contributors.

App
 [x] App can be created
 [x] App has the right month names
 [x] App can build header
 [x] App can add data

FileHelper
 [x] Can write correct data to file
 [x] Can overwrite file
 [x] Cant write file with wrong data

PaymentDate
 [x] Salary date can be created from valid arguments
 [x] Bonus date can be created from valid arguments
 [x] Cannot be created from invalid arguments

Settings
 [x] Settings can be created with arguments
 [x] Settings can be created with current timestamp
 [x] Settings can not be created with wrong filename argument
 [x] Settings can not be created with wrong year argument
```
