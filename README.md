# Check site position in Google search results

symfony 6.1 simple console app for check seo position for site in google, 
using https://api.serpdog.io

# How to use
###Minimal set of parameters:

php bin/console check:seo --pattern est.ua 'buy house in kiev'

###Full set of parameters:

php bin/console check:seo --pattern est.ua --lang:en --top:50 'buy house in kiev'

###Output
Searching...
Found at position: 2


