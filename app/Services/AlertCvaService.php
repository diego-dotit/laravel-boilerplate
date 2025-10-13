<?php

namespace App\Services;

use FeatureNinja\Cva\ClassVarianceAuthority;

class AlertCvaService
{
    public static function new(): ClassVarianceAuthority
    {
        return ClassVarianceAuthority::new(
            [
                'relative w-full rounded-lg border px-4 py-3 text-sm [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground [&>svg~*]:pl-7 shadow shadow-md shadow-black/15',
            ],
            [
                'variants' => [
                    'variant' => [
                        'default' => 'bg-background text-foreground',
                        'destructive' => 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
                        'primary' => 'border-primary/50 bg-primary/10 text-primary [&>svg]:text-primary',
                        'secondary' => 'border-secondary/50 bg-secondary/10 text-secondary [&>svg]:text-secondary',
                        'muted' => 'border-muted/50 bg-muted/10 text-muted [&>svg]:text-muted',
                        'accent' => 'border-accent/50 bg-accent/10 text-accent [&>svg]:text-accent',
                        'success' => 'border-success/50 bg-success/10 text-success [&>svg]:text-success',
                        'destructive-full' => 'bg-destructive border-0 text-destructive-foreground [&>svg]:text-destructive-foreground',
                        'primary-full' => 'bg-primary border-0 text-primary-foreground [&>svg]:text-primary-foreground',
                        'secondary-full' => 'bg-secondary border-0 text-secondary-foreground [&>svg]:text-secondary-foreground',
                        'muted-full' => 'bg-muted border-0 text-muted-foreground [&>svg]:text-muted-foreground',
                        'accent-full' => 'bg-accent border-0 text-accent-foreground [&>svg]:text-accent-foreground',
                        'success-full' => 'bg-success border-0 text-success-foreground [&>svg]:text-success-foreground',
                    ],
                ],
                'defaultVariants' => [
                    'variant' => 'default',
                ],
            ],
        );
    }
}
