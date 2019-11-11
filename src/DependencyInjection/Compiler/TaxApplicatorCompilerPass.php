<?php

declare(strict_types=1);

namespace MangoSylius\PaymentFeePlugin\DependencyInjection\Compiler;

use MangoSylius\PaymentFeePlugin\Model\Taxation\Applicator\OrderPaymentTaxesApplicator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class TaxApplicatorCompilerPass implements CompilerPassInterface
{
	/**
	 * @param ContainerBuilder $container
	 */
	public function process(ContainerBuilder $container): void
	{
		$this->registerToOrderItemsBasedStrategy($container);
		$this->registerToOrderItemUnitsBasedStrategy($container);
	}

	/**
	 * @param ContainerBuilder $container
	 */
	private function registerToOrderItemsBasedStrategy(ContainerBuilder $container): void
	{
		$definition = $container->getDefinition('sylius.taxation.order_items_based_strategy');
		$arg = $definition->getArgument(1);
		$arg[] = new Reference(OrderPaymentTaxesApplicator::class);
		$definition->setArgument(1, $arg);
	}

	/**
	 * @param ContainerBuilder $container
	 */
	private function registerToOrderItemUnitsBasedStrategy(ContainerBuilder $container): void
	{
		$definition = $container->getDefinition('sylius.taxation.order_item_units_based_strategy');
		$arg = $definition->getArgument(1);
		$arg[] = new Reference(OrderPaymentTaxesApplicator::class);
		$definition->setArgument(1, $arg);
	}
}
