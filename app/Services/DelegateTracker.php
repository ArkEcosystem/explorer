<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Network;
use App\Models\Block;
use App\Models\Round;

final class DelegateTracker
{
    public static function execute(int $height): array
    {
        $lastBlock       = Block::latestByHeight()->firstOrFail();
        $maxDelegates    = Network::delegateCount();
        $blockTime       = Network::blockTime();
        $round           = RoundCalculator::calculate($height);
        $activeDelegates = (new Monitor())->activeDelegates()->map(fn ($delegate) => $delegate->public_key);

        //     const blockTimeLookup = await Utils.forgingInfoCalculator.getBlockTimeLookup(this.app, height);

        //     const forgingInfo: Contracts.Shared.ForgingInfo = Utils.forgingInfoCalculator.calculateForgingInfo(
        //         timestamp,
        //         height,
        //         blockTimeLookup,
        //     );

        //     // Determine Next Forgers...
        //     const nextForgers: string[] = [];
        //     for (let i = 0; i <= maxDelegates; i++) {
        //         const delegate: string | undefined =
        //             activeDelegatesPublicKeys[(forgingInfo.currentForger + i) % maxDelegates];

        //         if (delegate) {
        //             nextForgers.push(delegate);
        //         }
        //     }

        //     if (activeDelegatesPublicKeys.length < maxDelegates) {
        //         return this.logger.warning(
        //             `Tracker only has ${Utils.pluralize(
        //                 "active delegate",
        //                 activeDelegatesPublicKeys.length,
        //                 true,
        //             )} from a required ${maxDelegates}`,
        //         );
        //     }

        //     // Determine Next Forger Usernames...
        //     this.logger.debug(
        //         `Next Forgers: ${JSON.stringify(
        //             nextForgers.slice(0, 5).map((publicKey: string) => this.getUsername(publicKey)),
        //         )}`,
        //     );

        //     const secondsToNextRound: number = (maxDelegates - forgingInfo.currentForger - 1) * blockTime;

        //     for (const delegate of this.delegates) {
        //         let indexInNextForgers = 0;
        //         for (let i = 0; i < nextForgers.length; i++) {
        //             if (nextForgers[i] === delegate.publicKey) {
        //                 indexInNextForgers = i;
        //                 break;
        //             }
        //         }

        //         if (indexInNextForgers === 0) {
        //             this.logger.debug(`${this.getUsername(delegate.publicKey)} will forge next.`);
        //         } else if (indexInNextForgers <= maxDelegates - forgingInfo.nextForger) {
        //             this.logger.debug(
        //                 `${this.getUsername(delegate.publicKey)} will forge in ${Utils.prettyTime(
        //                     indexInNextForgers * blockTime * 1000,
        //                 )}.`,
        //             );
        //         } else {
        //             this.logger.debug(`${this.getUsername(delegate.publicKey)} has already forged.`);
        //         }
        //     }

        //     this.logger.debug(`Round ${round.round} will end in ${Utils.prettyTime(secondsToNextRound * 1000)}.`);

        return [];
    }
}
