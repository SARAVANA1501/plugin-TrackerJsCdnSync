# Matomo TrackerJsCdnSync Plugin

### Description

Sync your tracker javascript files (tag-manager container files) to your favourite CDN.

###Supported Static file change events
_Tag-Manager container Create_

##Supported CDN
_AWS S3_

###Configure Aws S3 CDN with IAM Key and Secret
```
[TrackerJsCdnSync]
type = "aws-s3"
auth-type = "IAM-User"
bucket = ""
version = "latest"
region = ""
key = ""
secret = ""
```

###Configure Aws S3 CDN with Role based access
```
[TrackerJsCdnSync]
type = "aws-s3"
auth-type = "IAM-Role"
bucket = ""
version = "latest"
region = ""
```
