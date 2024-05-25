const appStimulus = startStimulusApp();
export const app = appStimulus.require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
);