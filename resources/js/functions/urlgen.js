import axios from "axios";
import {removeTrailingSlash} from "@/functions/utils";
import * as assert from "assert";

/**
 * @param url {String}
 * @param params {Object}   simple params object
 */
function queryString(url, params) {
    const queryParams = new URLSearchParams(params);
    return url +  (Object.keys(params).length ? ("?" + queryParams.toString()) : "");
}


export function urlPageInfo(pagename) {
    const params = {};
    pagename = removeTrailingSlash(pagename);
    return queryString(`/api/page/${pagename}`, params);
}

export function urlPageBlocks(pagename) {

    const params = {};
    pagename = removeTrailingSlash(pagename);
    return queryString(`/api/page/${pagename}/blocks`, params);
}

export function urlProductsSearchPaged(searchString, page = 1, perPage = 24) {
    const params = {
        str: searchString,
        page: page,
        perPage: perPage,
    };
    return queryString("/api/search", params);
}

export function urlCategories(manufacturer_id, limit = 500) {
    const params = {
        manufacturer_id: manufacturer_id,
        limit: limit,
    };
    return queryString("/api/categories/top", params);
}

export function urlProductsPaged(manufacturer_id, category_id = null, page = 1, perPage = 24) {
    const params = {
        manufacturer_id: manufacturer_id,
        category_id: category_id,
        page: page,
        perPage: perPage,
    };
    if (!category_id) {
        delete params.category_id;
    }
    return queryString("/api/products", params);
}

export function urlCategory(slug, manufacturer_id = null) {
    const params = {
        manufacturer_id: manufacturer_id,
    };
    return queryString(`/api/categories/byslug/${slug}`, params);
}

export function urlManufacturer(slug = null) {
    const params = new URLSearchParams({})
    return `/api/manufacturers/byslug/${slug}?` + params.toString();
}

export function urlManufacturersTop(limit = 5) {
    const params = {limit: limit};
    return queryString(`/api/manufacturers/top`, params);
}

export function urlManufacturersMenu(manufacturersLimit = 5, categoriesLimit = 20) {
// params moved to admin part
    const params = {
//        manufacturersLimit: manufacturersLimit,
//        categoriesLimit: categoriesLimit,
    };
    return queryString(`/api/manufacturers/menu`, params);
}

export function urlSettings(section) {
    const params = {};
    return queryString(`/api/settings/${section}`, params);
}