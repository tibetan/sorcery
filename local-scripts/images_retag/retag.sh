#!/usr/bin/env bash

REGISTRY=$1;
IMAGE_NAME=$2;
TAG=$3;

TAG_TAIL_1="_prev_1"
TAG_TAIL_2="_prev_2"
TAG_TAIL_3="_prev_3"

docker pull ${REGISTRY}/${IMAGE_NAME}:${TAG}
docker pull ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_1}
docker pull ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_2}

docker tag ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_2} ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_3}
docker tag ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_1} ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_2}
docker tag ${REGISTRY}/${IMAGE_NAME}:${TAG} ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_1}

docker push ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_3}
docker push ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_2}
docker push ${REGISTRY}/${IMAGE_NAME}:${TAG}${TAG_TAIL_1}

exit 0