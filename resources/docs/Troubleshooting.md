## Troubleshooting

### TLS negotiation issues
Download http://curl.haxx.se/ca/cacert.pem and set openssl.cafile=/path/to/cacert.pem in your php.ini file.

Alternatively you can run uspec like this:
```text
$ php -d openssl.cafile=/path/to/cacert.pem uspec.phar
```
