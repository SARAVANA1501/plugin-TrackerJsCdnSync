## Documentation

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