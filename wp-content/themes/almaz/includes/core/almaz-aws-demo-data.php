<?php
/**
 * Copyright 2010-2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * This file is licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License. A copy of
 * the License is located at
 *
 * http://aws.amazon.com/apache2.0/
 *
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 *
 *  ABOUT THIS PHP SAMPLE: This sample is part of the SDK for PHP Developer Guide topic at
 *  https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/service/s3-presigned-url.html
 *
 */
 

require ALMAZ_THEME_DIR . '/includes/vendor/aws-sdk/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$s3Client_almaz_theme = new Aws\S3\S3Client([
	'version' => 'latest',
	'region' => 'eu-north-1',
	'credentials' => [
		'key'    => 'AKIA5CMLGUN5LHIP6ZGO',
		'secret' => '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',
	],
]);

function almaz_get_presigned_url_aws_s3( $bucket, $key ) {
		global $s3Client_almaz_theme;
		$getobject = $s3Client_almaz_theme->getCommand('GetObject', ['Bucket' => $bucket,'Key' => $key]);
		$presigned_request = $s3Client_almaz_theme->createPresignedRequest($getobject, '+20 minutes'); 
		$presigned_url = (string)$presigned_request->getUri();
		return $presigned_url;
}