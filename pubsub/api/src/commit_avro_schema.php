<?php
/**
 * Copyright 2023 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/blob/main/pubsub/api/README.md
 */
namespace Google\Cloud\Samples\PubSub;

# [START pubsub_commit_avro_schema]

use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Schema;
use Google\Cloud\PubSub\V1\Schema\Type;
use Google\Cloud\PubSub\V1\SchemaServiceClient;

/**
 * Commit a new AVRO schema revision to an existing schema.
 *
 * @param string $projectId The ID of your Google Cloud Platform project.
 * @param string $schemaId The ID of the schema to commit.
 * @param string $avscFile The path to the Avro schema file.
 */
function commit_avro_schema(string $projectId, string $schemaId, string $avscFile): void
{
    $client = new SchemaServiceClient();
    $schemaName = $client->schemaName($projectId, $schemaId);
    try {
        $schema = new Schema();
        $definition = file_get_contents($avscFile);
        $schema->setName($schemaName)
            ->setType(Type::AVRO)
            ->setDefinition($definition);
        $response = $client->commitSchema($schemaName, $schema);
        printf("Committed a schema using an Avro schema: %s\n", $response->getName());
    } catch (ApiException $e) {
        printf("%s does not exist.\n", $schemaName);
    }
}
# [END pubsub_commit_avro_schema]
require_once __DIR__ . '/../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
