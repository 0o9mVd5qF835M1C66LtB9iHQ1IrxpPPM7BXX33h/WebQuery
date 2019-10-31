# well-known-query
Proposal to use .well-known/query to query a website by a search-term. Making it possible to decentralize web search operations. Every website manages their own "search engine", clients can search those by request .well-known/query?q=Hello. Clients can be aggregates which search several websites. To bootstrap this project one aggregate can implement plugins for Google, DuckDuckGo etc. until enough sites can be queried directly.

Please contact me for suggestions or improvements!

## 1. Create a new search query
POST .well-known/query?q=Hello
```json
{
  "mime-type" : "*",
}
```

## 2. Server sends location of new search query
201 Created
Location: .well-known/query/<SEARCH-ID>
  
## 3. Dynamically updated resource containing already gathered search results
GET .well-known/query/<SEARCH-ID>?[offset=0]

## 4. Actual response
200 OK
```json
{
  "state" : "collecting|done",
  "ttl" : 300,
  "results" : {
    "http://example.com/home" : {
      "context" : "Lorem ipsum *Hello* dolor sit amet",
      "location" : [52.0239023, 33.0923023],
      "mime-type" : "text/html",
      "language" : "en"
    }
  }
}
```
