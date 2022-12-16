import {writable} from "svelte/store";

export const globalLoading = writable(false);
export const modalSignUp = writable(false);
export const modalSignIn = writable(false);
export const slideCommunity = writable(false);
export const modalCreateCommunity = writable(false);
export const communities = writable([]);
export const selectedLink = writable(null);
export const modalFormLink = writable(false);
export const sidebarMobile = writable(false);
