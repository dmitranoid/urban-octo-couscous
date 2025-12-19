import axios from "axios";
import useSWRV from "swrv";
import {urlPageBlocks, urlProductsPaged, urlSettings} from "@/functions/urlgen";

export async function axiosFetcher(url) {
    try {
        const response = await axios.get(url);
        console.info('fetcher', url, response.data);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}

export async function setBlockData(paramsArray, blockVar, blockName) {
    // blockName = this.block-variable
    if (!paramsArray) {
        return;
    }
    const block = paramsArray.find(item => item.slug === blockName);
    if (!block) {
        return;
    }
    blockVar.title = block.name;
    blockVar.content = block.content;
    blockVar.image = block.image;
    blockVar.params = block.params;
}

export function getParam(paramVar, paramName) {
    if (!paramVar || !paramName) return undefined;
    const param = paramVar.find(param => param.Param.toLowerCase() === paramName.toLowerCase());
    if (param) {
        return param.Value;
    }
    return undefined;
}

export function paramsToArray(paramVar) {
    if (!paramVar) return undefined;
    let retData = [];
    paramVar.reduce((retData, item) => {retData.push(item.Value); return retData}, retData);
    return retData;
}

export async function searchProductsPaged(searchString, page=1, perPage=24) {
    const params = {
        str: searchString,
        page: page,
        perPage: perPage,
    }
    const response = await axios.get("/api/search", {params:params});
    return response.data.data;
}

export async function getManufacturer(slug) {
    const url = `/api/manufacturers/byslug/${slug}`;
    const {data: responseData, error:responseError} = useSWRV( ()=> slug && url, axiosFetcher);
    return responseData;
}

export async function getManufacturers() {
    const url = `/api/manufacturers/`;
    const resp = await axios.get(url);
    return resp.data.data;
}

export async function getCategories(manufacturer_id) {
    const params = new URLSearchParams({
        manufacturer_id: manufacturer_id,
        limit: 500,
    })
    const url = "/api/categories/top?" + params.toString() ;

    const {data: responseData, error:responseError} = useSWRV( ()=> manufacturer_id && url, axiosFetcher);
    return responseData;
}

export async function getProductsPaged(manufacturer_id, category_id=null, page=1, perPage = 24) {
    const url = urlProductsPaged(manufacturer_id, category_id, page, perPage);
    return await axios.get(url);
}

export async function getCategory(slug, manufacturer_id = null) {
    const params = new URLSearchParams({
        manufacturer_id: manufacturer_id,
    })
    const url = `/api/categories/byslug/${slug}?` + params.toString();

    const response = useSWRV(url, axiosFetcher);
    return response.data;
}

export async function getPageBlocks(page) {
    const url = urlPageBlocks(page)
    const resp = await axios.get(url);
    return resp.data.data;

}

export function getPageInfo() {}

export async function getSettings(section) {
    const resp = await axios.get(urlSettings(section));
    return resp.data.data;
}