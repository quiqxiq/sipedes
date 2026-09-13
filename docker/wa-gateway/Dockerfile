FROM golang:1.24-alpine AS builder

WORKDIR /build

ENV GOTOOLCHAIN=auto

RUN apk add --no-cache git ca-certificates tzdata

COPY go.mod ./
COPY . .
RUN go mod tidy
RUN CGO_ENABLED=0 GOOS=linux go build -ldflags="-s -w" -o wa-gateway .

# Runner Stage
FROM alpine:3.21

WORKDIR /app

RUN apk add --no-cache ca-certificates tzdata
ENV TZ=Asia/Jakarta

COPY --from=builder /build/wa-gateway /app/wa-gateway

RUN mkdir -p /app/storages

EXPOSE 3100

CMD ["/app/wa-gateway"]
