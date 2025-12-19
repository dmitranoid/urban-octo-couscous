import axios from "axios";
import LocalStorageCache from "swrv/esm/cache/adapters/localStorage";

export function getSWRVOptions() {
    return {
        cache: new LocalStorageCache('swrv'),
        revalidateOnFocus: false,
        dedupingInterval: 5 * 60 * 1000 //5 minutes
    }
}

export function getCacheStorage() {
    return new LocalStorageCache('swrv');
}

export function getDataFetcher() {
    return axiosFetcher;
}

export async function axiosFetcher(url) {
    try {
        const response = await axios.get(url);
        console.info('fetcher', url, response.data);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}

export function removeTrailingSlash(str) {
    return str.replace(/^\/+|\/+$/g, '');
}