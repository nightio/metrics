<?php

namespace PrismaMedia\MetricsBundle;

/**
 * Adds static labels to the metrics.
 */
class MetricLabeller implements MetricGenerator
{
    /**
     * @var MetricGenerator
     */
    private $metricProvider;

    /**
     * @var array
     */
    private $labels;

    /**
     * @param MetricGenerator $metricProvider
     * @param array           $labels         Labels to append to the metric
     */
    public function __construct(MetricGenerator $metricProvider, array $labels)
    {
        $this->metricProvider = $metricProvider;
        $this->labels = $labels;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetrics(): \Generator
    {
        /** @var Metric $metric */
        foreach ($this->metricProvider->getMetrics() as $metric) {
            yield new Metric(
                $metric->getName(),
                $metric->getValue(),
                array_replace($this->labels, $metric->getLabels())
            );
        }
    }
}
