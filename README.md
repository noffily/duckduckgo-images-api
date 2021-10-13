# DuckDuckGO images API PHP client

This is unofficial DuckDuckGo images API client and created just for fun.  
Please, use that package carefully and only for education purposes.  
The official API is https://duckduckgo.com/api  

The code for this package is based on ideas from [python package](https://github.com/deepanprabhu/duckduckgo-images-api)

## Install

`composer require noffily/duckduckgo-images-api`

## Example usage

```php
use DuckDuckGoImages\Client;

$client = new Client();
print_r($client->getImages('cars'));
```
Returns such as: 

```
Array
(
    [ads] => 
    [next] => i.js?q=cars&o=json&p=-1&s=100&u=bing&f=,,,&l=wt-wt
    [query] => cars
    [queryEncoded] => cars
    [response_type] => places
    [results] => Array
        (
            [0] => Array
                (
                    [height] => 1067
                    [image] => http://example.com/image.jpg
                    [source] => Bing
                    [thumbnail] => http://example.com/thumbnail.jpg
                    [title] => Awesome car
                    [url] => http://example.com/url
                    [width] => 1600
                )
            ...
        )
    [vqd] => Array
        (
            [cars] => 3-47107992990464668095541999824506671634-149382371238630188221044527126906250971
        )    
)            
```

## License

[MIT](https://choosealicense.com/licenses/mit/)
