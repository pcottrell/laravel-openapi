<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\HasApplicatorTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Core\HasCoreTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData\HasMetaDataTrait;

trait GeneralTrait
{
    use HasCoreTrait;
    use HasApplicatorTrait;
    use HasMetaDataTrait;
}
