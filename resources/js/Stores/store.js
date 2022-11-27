import {writable} from "svelte/store";

export const loading = writable(false);
export const modalSignUp = writable(false);
export const modalSignIn = writable(false);
export const slideCommunity = writable(false);
export const modalCreateCommunity = writable(false);
export const communities = writable([]);
export const selectedLink = writable(null);
export const modalFormLink = writable(false);
export const modalSettingCommunity = writable(false);
export const modalSettingCommunityActiveTab = writable('overview');
