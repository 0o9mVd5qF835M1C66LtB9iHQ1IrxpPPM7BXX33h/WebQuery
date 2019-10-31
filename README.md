# well-known-query
Proposal to use .well-known/query to query a website by a search-term. Making it possible to decentralize web search operations. Every website manages their own "search engine", clients can search those by request .well-known/query?q=Hello. Clients can be aggregates which search several websites. To bootstrap this project one aggregate can implement plugins for Google, DuckDuckGo etc. until enough sites can be queried directly.

## Request
POST .well-known/query?q=Hello
{
  "mime-type" : "*",
}

## Response
Location: .well-known/query/<SEARCH-ID>
  
## Request
Dynamic resource containing already gathered search results. 
GET .well-known/query/<SEARCH-ID>?[offset=0]

## Response
{
  "state" : "collecting|done",
  "results" : {
    "http://example.com/home" : {
      "context" : "Lorem ipsum *Hello* dolor sit amet",
      "location" : [lat, long],
      "mime-type" : "text/html"
      "content-rating" : "R", // perhaps use ring of trust?
      "language" : "en"
    }
  }
}


