# Matomo TrackerJsCdnSync Plugin

## Description

Sync your tracker javascript files (tag-manager container files) to your favourite CDN.

## Supported Static file change events

```
Tag-Manager container Create
Tag-Manager container Delete
```

## Supported CDN
AWS S3

## Configure Aws S3 CDN with IAM Key and Secret
```
[TrackerJsCdnSync]
type = "aws-s3"
auth-type = "IAM-User"
bucket = "<Replace with your bucket>"
version = "latest"
region = "<Replace with your region>"
key = "<Replace with your key>"
secret = "<Replace with your secret>"
```

## Configure Aws S3 CDN with Role based access
```
[TrackerJsCdnSync]
type = "aws-s3"
auth-type = "IAM-Role"
bucket = "<Replace with your bucket>"
version = "latest"
region = "<Replace with your region>"
```

## Configure CDN Url for embed code
It will update the CDN Url in tag-manager's embed code.
```
[TrackerJsCdnSync]
cdnUrl = "http://cdn.example.com/matomo-cdn" 
```